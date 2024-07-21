<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Claims</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .select2-selection__rendered {
            line-height: 34px !important;
        }

        .select2-container .select2-selection--single {
            height: 38px !important;
        }

        .select2-selection__arrow {
            height: 35px !important;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Create New Claim</h1>
        {{-- Success alert --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <!-- Display distinct claim causes -->
        <form action="{{ route('store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                {{-- Cancel button --}}
                <a href="/" class="bg-purple-400 text-white px-4 py-2 rounded">Cancel</a>
                <!-- LOB Field -->
                <div class="mb-4">
                    <label for="lob" class="block text-sm font-medium text-gray-700 mb-2">Line of Business
                        (LOB)</label>
                    <select id="lob" name="lob" required
                        class="mt-1 block w-full border-gray-300 px-2 py-3 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select a lob type</option>
                        @foreach ($lob_list as $lob)
                            {{-- Only add if the lob is KUR or PEN --}}
                            @if ($lob == 'KUR' || $lob == 'PEN')
                                <option value="{{ $lob }}">{{ $lob }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <!-- Claim Cause Field -->
                <div class="mb-4">
                    <label for="claim_cause" class="block text-sm font-medium text-gray-700 mb-2">Claim
                        Cause</label>
                    <select required id="claim_cause" name="claim_cause"
                        class="mt-1 block w-full border-gray-300 px-2 py-3 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select a claim cause</option>
                        {{-- Loop all claim cause recomendation --}}
                        @foreach ($claim_list as $claim)
                            <option value="{{ $claim }}">{{ $claim }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Claim Quantity Field -->
                <div class="mb-4">
                    <label for="claim_qty" class="block text-sm font-medium text-gray-700 mb-2">Claim
                        Quantity</label>
                    <input required id="claim_qty" name="claim_qty" type="number" min="0"
                        class="mt-1 block w-full border-gray-300 px-2 py-3 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Enter claim quantity">
                </div>

                <!-- Period Field -->
                <div class="mb-4">
                    <label for="period" class="block text-sm font-medium text-gray-700 mb-2">Claim Period</label>
                    <input required id="period" name="period" type="date"
                        class="mt-1 block w-full border-gray-300 px-2 py-3 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <!-- Claim Value Field -->
                <div class="mb-4">
                    <label for="claim_value" class="block text-sm font-medium text-gray-700 mb-2">Claim
                        Value</label>
                    <input required id="claim_value" name="claim_value" type="number" step="0.01" min="0"
                        class="mt-1 block w-full border-gray-300 px-2 py-3 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Enter claim value">
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="bg-cyan-400 text-white px-4 py-2 rounded hover:bg-blue-600">Submit</button>
            </div>
        </form>
    </div>

</body>

<script>
    $("#claim_cause").select2({
        tags: true,
    })
    $("#lob").select2({
        tags: false,
    })
</script>

</html>
