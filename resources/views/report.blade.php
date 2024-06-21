<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Template</title>

    @vite('resources/css/app.css')

</head>
<body class="antialiased flex flex-col h-screen  text-sm font-sans text-gray-700 tracking-tight">
    {{-- Header: This contains the company logo, name,
         address and other contact information. --}}
    <div class="w-full bg-gradient-to-t from-slate-200 via-white">
        <div class="container flex justify-between w-full mx-auto p-8">
            {{-- Company Info --}}
            <div class="flex flex-col justify-between w-5/12">
                {{-- Example company logo --}}
                <div class="mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="62" height="62" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-boxes"><path d="M2.97 12.92A2 2 0 0 0 2 14.63v3.24a2 2 0 0 0 .97 1.71l3 1.8a2 2 0 0 0 2.06 0L12 19v-5.5l-5-3-4.03 2.42Z"/><path d="m7 16.5-4.74-2.85"/><path d="m7 16.5 5-3"/><path d="M7 16.5v5.17"/><path d="M12 13.5V19l3.97 2.38a2 2 0 0 0 2.06 0l3-1.8a2 2 0 0 0 .97-1.71v-3.24a2 2 0 0 0-.97-1.71L17 10.5l-5 3Z"/><path d="m17 16.5-5-3"/><path d="m17 16.5 4.74-2.85"/><path d="M17 16.5v5.17"/><path d="M7.97 4.42A2 2 0 0 0 7 6.13v4.37l5 3 5-3V6.13a2 2 0 0 0-.97-1.71l-3-1.8a2 2 0 0 0-2.06 0l-3 1.8Z"/><path d="M12 8 7.26 5.15"/><path d="m12 8 4.74-2.85"/><path d="M12 13.5V8"/></svg>
                </div>

                {{-- Company name, address --}}
                <div class="flex flex-col gap-y-4">
                    <span class="flex flex-col font-bold">
                        <span class="text-base">{{ $payload['name'] }}</span>
                        <span class="font-normal text-[10px] text-gray-500">Absolutely fictional incorporation</span>
                    </span>
                </div>
            </div>

            <div class="flex flex-col justify-between text-[10px]">
                <div class="flex">
                    <span class="font-light">Date Generate: {{ now()->format('l, F j, Y') }}</span>
                </div>

                {{-- Contacts --}}
                <div class="flex flex-col">
                    <p>Address: {{ $payload['address'] }}</p>
                    <p>Phone: {{ $payload['phone'] }}</p>
                    <p>Email: {{ $payload['email'] }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- SVG Charts --}}
    <div class="container mx-auto my-8">
        <div class="flex w-full">
            <div id="bar-container" class="w-full"></div>
            <div id="pie-container" class="w-full"></div>
        </div>
    </div>

    {{-- Report Details: This is where you'll typically place the details
         about the transaction such as the items, quantity, amount, etc.  --}}
    <div class="container mx-auto p-8">
        <table class="border-collapse w-full text-[12px]">
            <thead>
                <tr class="text-left">
                    <th class="pb-2">Description</th>
                    <th class="pb-2">Qty</th>
                    <th class="pb-2 text-right">Price</th>
                    <th class="px-0 pb-2 text-right">Subtotal</th>
                    <th class="px-0 pb-2 text-right">Date Purchased</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @php
                    $total_price = 0;
                @endphp
                @foreach ($payload['items'] as $item)
                    @php
                        $total_price += $item['price'] * $item['total_quantity_sold'];
                    @endphp
                    <tr>
                        <td class="py-1">{{ $item['name']}}</td>
                        <td class="py-1">{{ $item['total_quantity_sold'] }}</td>
                        <td class="py-1 text-right">${{ number_format($item['price'], 2) }}</td>
                        <td class="py-1 text-right">
                            ${{ number_format($item['price'] * $item['total_quantity_sold'], 2) }}
                        </td>
                        <td class="py-1 text-right">
                            {{ Carbon\Carbon::create($item['date_purchased'])->format('l, F j, Y') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="container flex justify-end mx-auto p-8">
        <div class="flex flex-col">
            {{-- Subtotal, tax rate, tax amount and the
                 grand total for the invoice. --}}
            <div class="flex flex-col w-full mb-4">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span class="font-bold">${{ number_format($total_price, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Tax Rate</span>
                    <span class="font-bold">{{ $payload['tax_rate'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Tax Amount</span>
                    @php
                        $tax_amount = $total_price * ($payload['tax_rate'] / 100);
                    @endphp
                    <span class="font-bold">${{ number_format($tax_amount, 2) }}</span>
                </div>
            </div>

            <div class="flex w-auto bg-black font-medium px-4 py-2 text-white justify-between items-center rounded-lg">
                <span class="uppercase text-gray-400 font-bold mr-10">Total</span>
                <span class="text-base font-bold">${{ number_format($total_price + $tax_amount, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Highcharts.js Library --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript">
        Highcharts.chart('bar-container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Best Selling Products',
                align: 'left'
            },
            xAxis: {
                categories: [2021, 2022, 2023, 2024],
                crosshair: true,
                accessibility: {
                    description: 'Consumer Electronics'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Number of units sold'
                }
            },
            plotOptions: {
                animation: {
                    duration: 0
                },
                column: {
                    animation: {
                        duration: 0
                    },
                    pointPadding: 0.1,
                    borderWidth: 0
                }
            },
            series: [
                {
                    name: 'Phones',
                    data: [56, 12, 33, 65]
                },
                {
                    name: 'Laptop',
                    data: [77, 56, 23, 66]
                },
                {
                    name: 'Desktop',
                    data: [66, 42, 91, 55]
                },
            ]
        });

        Highcharts.chart('pie-container', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Mobile Devices Market Share'
            },
            tooltip: {
                valueSuffix: '%'
            },
            plotOptions: {
                animation: {
                    duration: 0
                },
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: [{
                        enabled: true,
                        distance: 20
                    }, {
                        enabled: true,
                        distance: -40,
                        format: '{point.percentage:.1f}%',
                        style: {
                            fontSize: '1.2em',
                            textOutline: 'none',
                            opacity: 0.7
                        },
                        filter: {
                            operator: '>',
                            property: 'percentage',
                            value: 10
                        }
                    }]
                }
            },
            series: [
                {
                    name: 'Percentage',
                    colorByPoint: true,
                    animation: {
                        duration: 0
                    },
                    data: [
                        {
                            name: 'Phones',
                            y: 55.02,
                            sliced: true,
                            selected: false,
                        },
                        {
                            name: 'Tablets',
                            sliced: true,
                            selected: false,
                            y: 26.71
                        },
                        {
                            name: 'Laptops',
                            y: 15.5,
                            sliced: true,
                            selected: false,
                        },
                    ]
                }
            ]
        });
    </script>
</body>
</html>
