<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Livewire;
use App\Models\Invoice;
use Carbon\Carbon;

class InvoiceDashboard extends Component {
    public $aggregationType = "overdue";
    public $dueDateRange = null;
    public $invoiceTypeTitle = "Overdue";
    public $selectedInvoice = null;
    public $overdueInvoices = [];
    public $pendingInvoices = [];
    public $invoices = [];

    public function getPendingApprovalData(){
        $this->pendingInvoices = Invoice::where('status', 'Pending Approval')->with('lineItems')->orderBy('invoice_date', 'asc')->get();
        $pendingApprovalTotal = $this->pendingInvoices->sum(fn ($invoice) => $invoice->lineItems->sum('price'));
        $topPendingInvoices = $this->pendingInvoices->sortByDesc(function ($invoice) {
            return $invoice->lineItems->sum('price');
        })->take(3);

        return compact('pendingApprovalTotal', 'topPendingInvoices');
    }

    public function getOverdueData() {
        $now = Carbon::now();
        $this->overdueInvoices = Invoice::where('status', 'Open')->where('due_date', '<', $now)->with('lineItems')->orderBy('invoice_date', 'asc')->get();
        $overdueTotal = $this->overdueInvoices->sum(fn ($invoice) => $invoice->lineItems->sum('price'));

        $agingBuckets = [
            '0-30'  => $this->overdueInvoices->whereBetween('due_date', [$now->copy()->subDays(30), $now])->sum(fn ($invoice) => $invoice->lineItems->sum('price')),
            '31-60' => $this->overdueInvoices->whereBetween('due_date', [$now->copy()->subDays(60), $now->copy()->subDays(31)])->sum(fn ($invoice) => $invoice->lineItems->sum('price')),
            '61-90' => $this->overdueInvoices->whereBetween('due_date', [$now->copy()->subDays(90), $now->copy()->subDays(61)])->sum(fn ($invoice) => $invoice->lineItems->sum('price')),
            '90+'   => $this->overdueInvoices->where('due_date', '<', $now->copy()->subDays(90))->sum(fn ($invoice) => $invoice->lineItems->sum('price')),
        ];

        return compact('overdueTotal', 'agingBuckets');
    }

    public function loadInvoices() {
        $now = Carbon::now();
        switch ($this->aggregationType) {
            case 'overdue':
                $this->invoices = $this->overdueInvoices;
                $this->invoiceTypeTitle = "Overdue Invoices";
                break;
            case 'pendingApproval':
                $this->invoices = $this->pendingInvoices;
                $this->invoiceTypeTitle = "Invoices Pending Approval";
                $this->dueDateRange = null;
                break;
        }
        switch($this->dueDateRange){
            case "0-30":
                $this->invoices = $this->invoices->whereBetween('due_date', [$now->copy()->subDays(30), $now]);
                $this->invoiceTypeTitle .= " (0 - 30 Days)";
                break;
            case "31-60":
                $this->invoices = $this->invoices->whereBetween('due_date', [$now->copy()->subDays(60), $now->copy()->subDays(31)]);
                $this->invoiceTypeTitle .= " (31 - 60 Days)";
                break;
            case "61-90":
                $this->invoices = $this->invoices->whereBetween('due_date', [$now->copy()->subDays(90), $now->copy()->subDays(61)]);
                $this->invoiceTypeTitle .= " (61 - 90 Days)";
                break;
            case "90+":
                $this->invoices = $this->invoices->where('due_date', '<', $now->copy()->subDays(90));
                $this->invoiceTypeTitle .= " (90+ Days)";
                break;
        }
        if($this->selectedInvoice === null){
            $this->selectedInvoice = $this->invoices->first();
        }
    }

    public function selectListedInvoice($invoiceId) {
        $this->selectedInvoice = Invoice::find($invoiceId);
    }

    public function selectUnlistedInvoice($invoiceId){
        $this->selectedInvoice = Invoice::find($invoiceId);
        $this->aggregationType = "pendingApproval";
    }

    public function changeAggregationType($type, $dueDateRange = null) {
        $this->aggregationType = $type;
        $this->dueDateRange = $dueDateRange;
        $this->selectedInvoice = null;
    }

    public function render() {
        $pendingApprovalData = $this->getPendingApprovalData();
        $overdueData = $this->getOverdueData();
        $this->loadInvoices();
        return view('livewire.invoice-dashboard', array_merge($pendingApprovalData, $overdueData));
    }
}
