@push('styles')
    <link rel="stylesheet" href="{{ asset('css/invoice-dashboard.css') }}">
@endpush
<div class="dashboardContent">
    <h1 class="dashboardTitle elementTitle">Invoices</h1>
    <div class="aggregatedDataRow">
        <div class="aggregatedDataContainer" id="overdueAggregatedContainer">
            <div class="aggregatedTotalsRow">
                <div class="totalOverdueAmountContainer">
                    <div
                        class="totalOverdueAmount clickable"
                        wire:click="changeAggregationType('overdue')"
                    >
                        <p class="totalOverdueAmountTitle">Overdue</p>
                        <p class="totalOverdueAmountData"><span class="mediumPrefix">$</span>{{ number_format($overdueTotal, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="agingBucketsRow">
                @foreach($agingBuckets as $range => $amount)
                    <div
                        class="agingBucket clickable"
                        wire:click="changeAggregationType('overdue', '{{ $range }}')"
                    >
                        <p class="agingBucketTitle">{{ $range }} days overdue</p>
                        <p class="agingBucketPoint"><span class="mediumPrefix">$</span>{{ number_format($amount, 2) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="aggregatedDataContainer barChart" id="pendingApprovalAggregatedContainer">
            <div class="aggregatedTotalsRow">
                <div class="totalOverdueAmountContainer">
                    <div
                        class="totalOverdueAmount clickable"
                        wire:click="changeAggregationType('pendingApproval')"
                    >
                        <p class="totalOverdueAmountTitle">Pending Approval</p>
                        <p class="totalOverdueAmountData"><span class="mediumPrefix">$</span>{{ number_format($pendingApprovalTotal, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="agingBucketsRow">
                @foreach($topPendingInvoices as $invoice)
                    <div
                        class="agingBucket barChart clickable"
                        wire:click="selectUnlistedInvoice({{ $invoice->invoice_id }})"
                    >
                        <p class="agingBucketPoint"><span class="mediumPrefix">$</span>{{ number_format($invoice->lineItemTotal, 2) }}</p>
                        <p class="agingBucketTitle"><span class="mediumPrefix">#</span> {{ $invoice->invoice_id }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="detailDataRow aggregatedDataContainer">
        <div id="invoiceContainer">
            <div id="invoiceListContainer">
                <h2 class="elementTitle">{{ $invoiceTypeTitle }}</h2>
                <div id="invoiceList" class="hideScrollbar">
                    @foreach($invoices as $invoice)
                        <div
                            class="invoiceItem clickable{{ $invoice->invoice_id === $selectedInvoice->invoice_id ? ' selected' : '' }}"
                            wire:click="selectListedInvoice({{ $invoice->invoice_id }})"
                        >
                            <div class="invoiceIdentifiers">
                                <p class="invoiceListDataPoint">{{ $invoice->customer_name }}</p>
                                <p class="invoiceListDataPoint"># {{ $invoice->invoice_id }}</p>
                            </div>
                            <p class="invoiceListTotal"><span class="mediumPrefix">$</span>{{ number_format($invoice->lineItemTotal, 2) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div id="invoiceDetail">
                <div class="invoiceInformation">
                    <p class="invoiceTotal"><span class="smallPrefix">$</span>{{ number_format($selectedInvoice->lineItemTotal, 2) }}</p>
                    <div class = "invoiceDataPoints">
                        <div class="invoiceDataPointContainer">
                            <div class="invoiceDetailSvgContainer">
                                <svg class="invoiceDetailSvg" xmlns="http://www.w3.org/2000/svg" viewBox="-7.145 -7.145 200 200" width="16" height="16">
                                    <desc>Sign Hashtag Streamline Icon: https://streamlinehq.com</desc>
                                    <g id="sign-hashtag--mail-sharp-sign-hashtag-tag">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.6325 56.37625h172.445" stroke-width="16"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.6325 129.33375h172.445" stroke-width="16"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m149.23125000000002 6.6325 -33.1625 172.445" stroke-width="16"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m76.27375 6.6325 -33.1625 172.445" stroke-width="16"></path>
                                    </g>
                                </svg>
                            </div>
                            <div>
                                <p class="invoiceDataPointTitle">Invoice Number</p>
                                <p class="invoiceDataPoint">{{ $selectedInvoice->invoice_id }}</p>
                            </div>
                        </div>
                        <div class="invoiceDataPointContainer">
                            <div class="invoiceDetailSvgContainer">
                                <svg class="invoiceDetailSvg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" xml:space="preserve">
                                    <path d="M135.832 140.848h-70.9c-2.9 0-5.6-1.6-7.4-4.5-1.4-2.3-1.4-5.7 0-8.6l4-8.2c2.8-5.6 9.7-9.1 14.9-9.5 1.7-.1 5.1-.8 8.5-1.6 2.5-.6 3.9-1 4.7-1.3-.2-.7-.6-1.5-1.1-2.2-6-4.7-9.6-12.6-9.6-21.1 0-14 9.6-25.3 21.5-25.3s21.5 11.4 21.5 25.3c0 8.5-3.6 16.4-9.6 21.1-.5.7-.9 1.4-1.1 2.1.8.3 2.2.7 4.6 1.3 3 .7 6.6 1.3 8.4 1.5 5.3.5 12.1 3.8 14.9 9.4l3.9 7.9c1.5 3 1.5 6.8 0 9.1-1.6 2.9-4.4 4.6-7.2 4.6zm-35.4-78.2c-9.7 0-17.5 9.6-17.5 21.3 0 7.4 3.1 14.1 8.2 18.1.1.1.3.2.4.4 1.4 1.8 2.2 3.8 2.2 5.9 0 .6-.2 1.2-.7 1.6-.4.3-1.4 1.2-7.2 2.6-2.7.6-6.8 1.4-9.1 1.6-4.1.4-9.6 3.2-11.6 7.3l-3.9 8.2c-.8 1.7-.9 3.7-.2 4.8.8 1.3 2.3 2.6 4 2.6h70.9c1.7 0 3.2-1.3 4-2.6.6-1 .7-3.4-.2-5.2l-3.9-7.9c-2-4-7.5-6.8-11.6-7.2-2-.2-5.8-.8-9-1.6-5.8-1.4-6.8-2.3-7.2-2.5-.4-.4-.7-1-.7-1.6 0-2.1.8-4.1 2.2-5.9.1-.1.2-.3.4-.4 5.1-3.9 8.2-10.7 8.2-18-.2-11.9-8-21.5-17.7-21.5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="invoiceDataPointTitle">Customer Name</p>
                                <p class="invoiceDataPoint">{{ $selectedInvoice->customer_name }}</p>
                            </div>
                        </div>
                        <div class="invoiceDataPointContainer">
                            <div class="invoiceDetailSvgContainer">
                                <svg class="invoiceDetailSvg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" width="20" height="20">
                                    <desc>Loading 4 Line Streamline Icon: https://streamlinehq.com</desc>
                                    <path d="M100 41.66666666666667a12.5 12.5 0 1 1 0 -25 12.5 12.5 0 0 1 0 25ZM65.70833333333334 52.80833333333334a12.5 12.5 0 1 1 -14.950000000000001 -20.033333333333335 12.5 12.5 0 0 1 14.950000000000001 20.033333333333335ZM28.76666666666667 90.00000000000001a12.5 12.5 0 1 0 7.983333333333333 -23.691666666666666 12.5 12.5 0 0 0 -7.983333333333333 23.691666666666666Zm15.75 28.025000000000002a12.5 12.5 0 1 1 -23.775000000000002 7.7250000000000005 12.5 12.5 0 0 1 23.775000000000002 -7.7250000000000005Zm23.958333333333336 46.625a12.5 12.5 0 1 0 -20.033333333333335 -14.950000000000001 12.5 12.5 0 0 0 20.033333333333335 14.950000000000001ZM100 158.33333333333334a12.5 12.5 0 1 1 0 25 12.5 12.5 0 0 1 0 -25Zm51.75 -8.375a12.491666666666669 12.491666666666669 0 1 0 -20.400000000000002 14.416666666666668 12.491666666666669 12.491666666666669 0 0 0 20.400000000000002 -14.416666666666668Zm3.7250000000000005 -31.933333333333334a12.5 12.5 0 1 1 23.858333333333334 7.466666666666668 12.5 12.5 0 0 1 -23.858333333333334 -7.466666666666668Zm8.025 -51.800000000000004a12.5 12.5 0 1 0 7.466666666666668 23.858333333333334 12.5 12.5 0 0 0 -7.466666666666668 -23.858333333333334Zm-29.21666666666667 -13.416666666666668a12.5 12.5 0 1 1 14.700000000000001 -20.225 12.5 12.5 0 0 1 -14.700000000000001 20.225Z" stroke-width="8.3333"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="invoiceDataPointTitle">Status</p>
                                <p class="invoiceDataPoint">{{ $selectedInvoice->status }}</p>
                            </div>
                        </div>
                        <div class="invoiceDataPointContainer">
                            <div class="invoiceDetailSvgContainer">
                                <svg class="invoiceDetailSvg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" viewBox="0 0 20 20">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round">
                                        <g transform="translate(-451.000000, -748.000000)" id="Group" stroke="#000000" stroke-width="2">
                                            <g transform="translate(449.000000, 746.000000)" id="Shape">
                                                <path d="M17,2 L17,4"></path>
                                                <path d="M7,2 L7,4"></path>
                                                <path d="M18,11.5 L18,17.9933387 M18.0043926,21.0066613 L18,20.9933387"></path>
                                                <path d="M8.03064542,21 C7.42550126,21 6.51778501,21 5.30749668,21 C4.50512981,21 4.2141722,20.9218311 3.92083887,20.7750461 C3.62750553,20.6282612 3.39729582,20.4128603 3.24041943,20.1383964 C3.08354305,19.8639324 3,19.5916914 3,18.8409388 L3,7.15906122 C3,6.4083086 3.08354305,6.13606756 3.24041943,5.86160362 C3.39729582,5.58713968 3.62750553,5.37173878 3.92083887,5.22495386 C4.2141722,5.07816894 4.50512981,5 5.30749668,5 L18.6925033,5 C19.4948702,5 19.7858278,5.07816894 20.0791611,5.22495386 C20.3724945,5.37173878 20.6027042,5.58713968 20.7595806,5.86160362 C20.9164569,6.13606756 21,7.24671889 21,7.99747152"></path>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div>
                                <p class="invoiceDataPointTitle">Due</p>
                                <p class="invoiceDataPoint">{{ date('m-d-Y', strtotime($selectedInvoice->due_date)) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="invoiceLineItemList">
                    <h3 class="elementTitle">Line Items</h3>
                    <table class="fillHeightTable">
                        <thead>
                            <tr class="fillHeightRow">
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>UoM</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($selectedInvoice->lineItems as $lineItem)
                            <tr class="fillHeightRow">
                                <td>{{ $lineItem->item_name }}</td>
                                <td>{{ $lineItem->quantity }}</td>
                                <td>{{ $lineItem->unit_of_measure }}</td>
                                <td>${{ number_format($lineItem->price, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
