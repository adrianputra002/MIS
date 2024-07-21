<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <style>
        * {
            font-family: 'figtree', sans-serif;
            transition: all 0.25s linear;
        }
    </style>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="antialiased">
    <div class="container mx-auto p-6">
        {{-- container for funtion buttons --}}
        <div class="flex justify-end mb-4">
            <a href="/create" class="bg-cyan-400 text-white px-4 py-2 rounded mr-2">Tambahkan Data</a>
            <a href="/viewDBPenampung" class="bg-cyan-400 text-white px-4 py-2 rounded mr-2">DB Penampung</a>
            {{-- Submit button to integrate, also onclick confirmation --}}
            <form action="{{ route('integrate') }}" method="POST">
                @csrf
                <button type="submit" onclick="return confirm('Apakah kamu mau melakukan integrasi ?')"
                    class="bg-cyan-400 text-white px-4 py-2 rounded">Integrasi</button>
            </form>

        </div>
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="text-left px-4 py-3 border-b">LOB</th>
                    <th class="text-left px-4 py-3 border-b">Penyebab Kematian</th>
                    <th class="text-right px-4 py-3 border-b">Jumlah Nasabah</th>
                    <th class="text-right px-4 py-3 border-b">Beban Klaim</th>
                </tr>
            </thead>
            <tbody>
                <!-- Declare variables -->
                @php
                    $current_lob = '';
                    $lob_totals = [];
                    $grand_totals = ['qty' => 0, 'value' => 0];
                @endphp

                <!-- Loop through each claim -->
                @foreach ($claims as $claim)
                    @if ($claim->lob != $current_lob)
                        @if ($current_lob)
                            <!-- Print sub-total for previous LOB -->
                            <tr class="font-bold  text-white bg-cyan-400">
                                <td colspan="2" class="px-4 py-3 border-b text-left">Sub Total {{ $current_lob }}
                                </td>
                                <td class="px-4 py-3 border-b text-right">
                                    {{ number_format($lob_totals[$current_lob]['qty'], 0, ',', '.') }}</td>
                                <td class="px-4 py-3 border-b text-right">
                                    {{ number_format($lob_totals[$current_lob]['value'], 2, ',', '.') }}</td>
                            </tr>
                        @endif

                        <!-- Update current LOB and initialize totals -->
                        @php
                            $current_lob = $claim->lob;
                            $lob_totals[$current_lob] = ['qty' => 0, 'value' => 0];
                        @endphp
                    @endif

                    <!-- Display each claim -->
                    <tr>
                        <td class="px-4 py-3 border-b">{{ $claim->lob }}</td>
                        <td class="px-4 py-3 border-b">{{ $claim->claim_cause }}</td>
                        <td class="px-4 py-3 border-b text-right">{{ number_format($claim->claim_qty, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 border-b text-right">{{ number_format($claim->claim_value, 2, ',', '.') }}
                        </td>
                    </tr>

                    <!-- Update totals for current LOB and grand totals -->
                    @php
                        $lob_totals[$current_lob]['qty'] += $claim->claim_qty;
                        $lob_totals[$current_lob]['value'] += $claim->claim_value;
                        $grand_totals['qty'] += $claim->claim_qty;
                        $grand_totals['value'] += $claim->claim_value;
                    @endphp
                @endforeach

                <!-- Print sub-total for the last LOB -->
                @if ($current_lob)
                    <tr class="font-bold text-white bg-cyan-400">
                        <td colspan="2" class="px-4 py-3 border-b text-left">Sub Total {{ $current_lob }}</td>
                        <td class="px-4 py-3 border-b text-right">
                            {{ number_format($lob_totals[$current_lob]['qty'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 border-b text-right">
                            {{ number_format($lob_totals[$current_lob]['value'], 2, ',', '.') }}</td>
                    </tr>
                @endif

                <!-- Grand Total -->
                <tr class="font-bold bg-gray-400 text-white">
                    <td colspan="2" class="px-4 py-3 border-b text-left">Grand Total</td>
                    <td class="px-4 py-3 border-b text-right">{{ number_format($grand_totals['qty'], 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-3 border-b text-right">{{ number_format($grand_totals['value'], 2, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
