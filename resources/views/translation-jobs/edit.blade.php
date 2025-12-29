@extends('components.layout')

@section('title', 'Edit Translation Job')
{{-- @section('page_title', 'Edit Translation Job') --}}

@section('content')
<div class="max-w-4xl mx-auto py-6">

    <form action="{{ route('translation-jobs.update', ['translation_job' => $translation_job->id]) }}" method="POST" class="bg-white shadow-md rounded-lg p-8 space-y-3">
    @csrf
    @method('PUT')

    <!-- Client -->
    <div>
        <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">Client</label>
        <select name="client_id" id="client_id"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
            required>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" {{ $translation_job->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
            @endforeach
        </select>
        @error('client_id') <span class="text-red-500">{{ $errors->first('client_id') }}</span> @enderror
    </div>


    <!-- Service -->
    <div>
        <label for="service" class="block text-sm font-medium text-gray-700 mb-2">Service</label>
        <select name="service" id="service"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
            required>
            <option value="Translation FR-NL" {{ $translation_job->service == 'Translation FR-NL' ? 'selected' : '' }}>Translation FR-NL</option>
             <option value="Revision FR-NL" {{ $translation_job->service == 'Revision FR-NL' ? 'selected' : '' }}>Revision FR-NL</option>
            <option value="Translation EN-NL" {{ $translation_job->service == 'Translation EN-NL' ? 'selected' : '' }}>Translation EN-NL</option>
            <option value="Revision EN-NL" {{ $translation_job->service == 'Revision EN-NL' ? 'selected' : '' }}>Revision EN-NL</option>

            <option value="Translation ES-NL" {{ $translation_job->service == 'Translation ES-NL' ? 'selected' : '' }}>Translation ES-NL</option>
            <option value="Revision ES-NL" {{ $translation_job->service == 'Revision ES-NL' ? 'selected' : '' }}>Revision ES-NL</option>
            <option value="PEMT FR-NL" {{ $translation_job->service == 'PEMT FR-NL' ? 'selected' : '' }}>PEMT FR-NL</option>
            <option value="PEMT EN-NL" {{ $translation_job->service == 'PEMT EN-NL' ? 'selected' : '' }}>PEMT EN-NL</option>
            <option value="Translation PT-NL" {{ $translation_job->service == 'Translation PT-NL' ? 'selected' : '' }}>Translation PT-NL</option>
            <option value="Revision PT-NL" {{ $translation_job->service == 'Revision PT-NL' ? 'selected' : '' }}>Revision PT-NL</option>
        </select>
        @error('service') <span class="text-red-500">{{ $errors->first('service') }}</span> @enderror
    </div>

     <!-- PO Number -->
    <div>
        <label for="po_number" class="block text-sm font-medium text-gray-700 mb-2">PO Number</label>
        <input type="text" name="po_number" id="po_number" value="{{ old('po_number', $translation_job->po_number) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
            required>
        @error('po_number') <span class="text-red-500">{{ $errors->first('po_number') }}</span> @enderror
    </div>


    <!-- Title -->
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Job Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $translation_job->title) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
            required>
        @error('title') <span class="text-red-500">{{ $errors->first('title') }}</span> @enderror
    </div>

    <!-- Pricing and Deadline Section -->
    <div class="flex space-x-6">
        <!-- Pricing Fields -->
        <div class="flex-1 space-y-4">
            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                <div class="relative">
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $translation_job->price) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3 pr-8"
                        required>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">€</span>
                </div>
                @error('price') <span class="text-red-500">{{ $errors->first('price') }}</span> @enderror
            </div>

            <!-- VAT -->
            <div>
                <label for="vat" class="block text-sm font-medium text-gray-700 mb-2">VAT</label>
                <div class="relative">
                    <input type="number" step="0.01" name="vat" id="vat" value="{{ old('vat', $translation_job->vat ?? 0) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3 pr-8"
                        >
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">€</span>
                </div>
                @error('vat') <span class="text-red-500">{{ $errors->first('vat') }}</span> @enderror
            </div>

            <!-- Job Total -->
            <div>
                <label for="total_price" class="block text-sm font-medium text-gray-700 mb-2">Job Total</label>
                <div class="relative">
                    <input type="number" step="0.01" name="total_price" id="total_price" value="{{ old('total_price', $translation_job->total_price) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3 pr-8">
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">€</span>
                </div>
                @error('total_price') <span class="text-red-500">{{ $errors->first('total_price') }}</span> @enderror
            </div>
        </div>

        <!-- Deadline -->
        <div class="flex-1 space-y-4">
            <!-- Quantity -->
            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                <div class="flex">
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $translation_job->quantity) }}"
                        class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3"
                        required>
                    <button type="button" id="min_fee"
                        class="px-4 py-2 bg-gray-200 text-gray-700 border border-l-0 border-gray-300 rounded-none hover:bg-gray-300">Min fee</button>
                    <button type="button" id="matches"
                        class="px-4 py-2 bg-gray-200 text-gray-700 border border-l-0 border-gray-300 rounded-r-md hover:bg-gray-300" onclick="showModal()">Matches</button>
                </div>
                @error('quantity') <span class="text-red-500">{{ $errors->first('quantity') }}</span> @enderror
            </div>

            <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">Deadline</label>
            <input type="date" name="deadline" id="deadline" value="{{ old('deadline', $translation_job->deadline ? \Carbon\Carbon::parse($translation_job->deadline)->format('Y-m-d') : '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3"
                required>
            @error('deadline') <span class="text-red-500">{{ $errors->first('deadline') }}</span> @enderror
        </div>
    </div>



    <!-- Submit -->
    <div class="pt-6 text-right">
        <button type="submit"
            class="px-6 py-3 bg-[#702963] text-white font-semibold rounded-md hover:bg-blue-700">
            Update Job
        </button>
    </div>
</form>

<!-- Modal -->
<div id="matches-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center p-6 border-b">
            <h5 class="text-xl font-semibold">CAT CALCULATION</h5>
            <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl" onclick="hideModal()">&times;</button>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-12 gap-4 mb-4">
                <div class="col-span-3 font-medium">Match type</div>
                <div class="col-span-2 font-medium"># of words</div>
                <div class="col-span-1 font-medium text-center">x</div>
                <div class="col-span-2 font-medium">Percentage</div>
                <div class="col-span-1 font-medium text-center">=</div>
                <div class="col-span-3 font-medium">CAT calculation</div>
            </div>
            <hr class="mb-4">
            <!-- Perfect Match -->
            <div class="grid grid-cols-12 gap-4 mb-4">
                <div class="col-span-3 flex items-center">Perfect Match</div>
                <div class="col-span-2"><input type="number" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" id="PMcount" placeholder="# Perf Match" oninput="calculateMatches()"></div>
                <div class="col-span-1 flex items-center justify-center">x</div>
                <div class="col-span-2"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" id="PMpercentage" value="0" oninput="calculateMatches()"></div>
                <div class="col-span-1 flex items-center justify-center">=</div>
                <div class="col-span-3"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm bg-gray-50 p-2" id="PMtotal" placeholder="Amount" readonly></div>
            </div>
            <!-- Context Match -->
            <div class="grid grid-cols-12 gap-4 mb-4">
                <div class="col-span-3 flex items-center">Context Match</div>
                <div class="col-span-2"><input type="number" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" id="CMcount" placeholder="# Context M" oninput="calculateMatches()"></div>
                <div class="col-span-1 flex items-center justify-center">x</div>
                <div class="col-span-2"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" id="CMpercentage" value="0.10" oninput="calculateMatches()"></div>
                <div class="col-span-1 flex items-center justify-center">=</div>
                <div class="col-span-3"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm bg-gray-50 p-2" id="CMtotal" placeholder="Amount" readonly></div>
            </div>
            <!-- Xtranslated -->
            <div class="grid grid-cols-12 gap-4 mb-4">
                <div class="col-span-3 flex items-center">Xtranslated</div>
                <div class="col-span-2"><input type="number" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" id="Xcount" placeholder="# Xmatch" oninput="calculateMatches()"></div>
                <div class="col-span-1 flex items-center justify-center">x</div>
                <div class="col-span-2"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" id="Xpercentage" value="0.10" oninput="calculateMatches()"></div>
                <div class="col-span-1 flex items-center justify-center">=</div>
                <div class="col-span-3"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm bg-gray-50 p-2" id="Xtotal" placeholder="Amount" readonly></div>
            </div>
            <!-- Repetitions -->
            <div class="grid grid-cols-12 gap-4 mb-4">
                <div class="col-span-3 flex items-center">Repetitions</div>
                <div class="col-span-2"><input type="number" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" id="Repcount" placeholder="# Reps" oninput="calculateMatches()"></div>
                <div class="col-span-1 flex items-center justify-center">x</div>
                <div class="col-span-2"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" id="Reppercentage" value="0.10" oninput="calculateMatches()"></div>
                <div class="col-span-1 flex items-center justify-center">=</div>
                <div class="col-span-3"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm bg-gray-50 p-2" id="Reptotal" placeholder="Amount" readonly></div>
            </div>
            <!-- 100% Match -->
            <div class="grid grid-cols-12 gap-4 mb-4">
                <div class="col-span-3 flex items-center">100% Match</div>
                <div class="col-span-2"><input type="number" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" id="count100" placeholder="# 100% Match" oninput="calculateMatches()"></div>
                <div class="col-span-1 flex items-center justify-center">x</div>
                <div class="col-span-2"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" id="percentage100" value="0.15" oninput="calculateMatches()"></div>
                <div class="col-span-1 flex items-center justify-center">=</div>
                <div class="col-span-3"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm bg-gray-50 p-2" id="total100" placeholder="Amount" readonly></div>
            </div>
            <!-- 95%-99% Match -->
            <div class="grid grid-cols-12 gap-4 mb-4">
                <div class="col-span-3 flex items-center">95%-99% Match</div>
                <div class="col-span-2"><input type="number" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" id="count95" placeholder="# 95%-99%" oninput="calculateMatches()"></div>
                <div class="col-span-1 flex items-center justify-center">x</div>
                <div class="col-span-2"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" id="percentage95" value="0.20" oninput="calculateMatches()"></div>
                <div class="col-span-1 flex items-center justify-center">=</div>
                <div class="col-span-3"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm bg-gray-50 p-2" id="total95" placeholder="Amount" readonly></div>
            </div>
            <!-- 85%-94% Match -->
            <div class="grid grid-cols-12 gap-4 mb-4">
                <div class="col-span-3 flex items-center">85%-94% Match</div>
                <div class="col-span-2"><input type="number" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" id="count85" placeholder="# 85%-94%" oninput="calculateMatches()"></div>
                <div class="col-span-1 flex items-center justify-center">x</div>
                <div class="col-span-2"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" id="percentage85" value="0.40" oninput="calculateMatches()"></div>
                <div class="col-span-1 flex items-center justify-center">=</div>
                <div class="col-span-3"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm bg-gray-50 p-2" id="total85" placeholder="Amount" readonly></div>
            </div>
            <!-- 75%-84% Match -->
            <div class="grid grid-cols-12 gap-4 mb-4">
                <div class="col-span-3 flex items-center">75%-84% Match</div>
                <div class="col-span-2"><input type="number" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" id="count75" placeholder="# 75%-84%" oninput="calculateMatches()"></div>
                <div class="col-span-1 flex items-center justify-center">x</div>
                <div class="col-span-2"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" id="percentage75" value="0.60" oninput="calculateMatches()"></div>
                <div class="col-span-1 flex items-center justify-center">=</div>
                <div class="col-span-3"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm bg-gray-50 p-2" id="total75" placeholder="Amount" readonly></div>
            </div>
            <!-- 50%-74% Match -->
            <div class="grid grid-cols-12 gap-4 mb-4">
                <div class="col-span-3 flex items-center">50%-74% Match</div>
                <div class="col-span-2"><input type="number" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" id="count50" placeholder="# 50%-74%" oninput="calculateMatches()"></div>
                <div class="col-span-1 flex items-center justify-center">x</div>
                <div class="col-span-2"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" id="percentage50" value="1.00" oninput="calculateMatches()"></div>
                <div class="col-span-1 flex items-center justify-center">=</div>
                <div class="col-span-3"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm bg-gray-50 p-2" id="total50" placeholder="Amount" readonly></div>
            </div>
            <!-- No Match -->
            <div class="grid grid-cols-12 gap-4 mb-4">
                <div class="col-span-3 flex items-center">No Match</div>
                <div class="col-span-2"><input type="number" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" id="numberofCATwords" placeholder="# No match" oninput="calculateMatches()"></div>
                <div class="col-span-1 flex items-center justify-center">x</div>
                <div class="col-span-2"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" id="priceperCATword" value="1.00" oninput="calculateMatches()"></div>
                <div class="col-span-1 flex items-center justify-center">=</div>
                <div class="col-span-3"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm bg-gray-50 p-2" id="CATtotal" placeholder="Amount" readonly></div>
            </div>
            <hr class="mb-4">
            <!-- Total -->
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-3"></div>
                <div class="col-span-2"></div>
                <div class="col-span-1"></div>
                <div class="col-span-2 flex items-center justify-end font-medium">TOTAL:</div>
                <div class="col-span-1 flex items-center justify-center">=</div>
                <div class="col-span-3"><input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm bg-gray-100 p-2 font-semibold" id="Endtotal" placeholder="Amount" readonly></div>
            </div>
        </div>
        <div class="flex justify-end space-x-4 p-6 border-t">
            <button type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400" onclick="hideModal()">Close</button>
            <button type="button" class="px-4 py- bg-[#702963] text-white rounded-md hover:bg-blue-700" onclick="saveAndClose()">Save changes</button>
        </div>
    </div>
</div>

   <!-- Calculator -->
    <div class="border-t pt-6 mt-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Price Calculator</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="po_amount" class="block text-sm font-medium text-gray-700 mb-2">PO Amount</label>
                <input type="number" id="po_amount" min="0"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4">
            </div>
            <div>
                <label for="rate" class="block text-sm font-medium text-gray-700 mb-2">Rate per Word (€)</label>
                <select id="rate"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4">
                    <option value="0.09">0.09</option>
                    <option value="0.10">0.10</option>
                    <option value="0.11" selected>0.11</option>
                    <option value="0.12">0.12</option>
                    <option value="0.13">0.13</option>
                    <option value="0.14">0.14</option>
                </select>
            </div>
            <div>
                <label for="result" class="block text-sm font-medium text-gray-700 mb-2">Total Price (€)</label>
                <input type="number" step="0.01" id="result" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-50 p-4">
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const PoInput = document.getElementById('po_amount');
    const rateSelect = document.getElementById('rate');
    const resultInput = document.getElementById('result');

    function calculate() {
        const amount = parseFloat(PoInput.value) || 0;
        const rate = parseFloat(rateSelect.value);
        const total = amount / rate;
        resultInput.value = total.toFixed(2);
    }

    PoInput.addEventListener('input', calculate);
    rateSelect.addEventListener('change', calculate);

    document.getElementById('min_fee').addEventListener('click', function() {
        document.getElementById('quantity').value = 1;
        document.getElementById('total_price').value = 40;
    });

    // Modal functions
    const matches = [
        { countId: 'PMcount', percId: 'PMpercentage', totalId: 'PMtotal' },
        { countId: 'CMcount', percId: 'CMpercentage', totalId: 'CMtotal' },
        { countId: 'Xcount', percId: 'Xpercentage', totalId: 'Xtotal' },
        { countId: 'Repcount', percId: 'Reppercentage', totalId: 'Reptotal' },
        { countId: 'count100', percId: 'percentage100', totalId: 'total100' },
        { countId: 'count95', percId: 'percentage95', totalId: 'total95' },
        { countId: 'count85', percId: 'percentage85', totalId: 'total85' },
        { countId: 'count75', percId: 'percentage75', totalId: 'total75' },
        { countId: 'count50', percId: 'percentage50', totalId: 'total50' },
        { countId: 'numberofCATwords', percId: 'priceperCATword', totalId: 'CATtotal' },
    ];

    window.showModal = function() {
        document.getElementById('matches-modal').classList.remove('hidden');
    };

    window.hideModal = function() {
        document.getElementById('matches-modal').classList.add('hidden');
    };

    window.calculateMatches = function() {
        matches.forEach(match => {
            const count = parseFloat(document.getElementById(match.countId).value) || 0;
            const perc = parseFloat(document.getElementById(match.percId).value) || 0;
            const total = count * perc;
            document.getElementById(match.totalId).value = total.toFixed(2);
        });
        calculateTotal();
    };

    function calculateTotal() {
        let total = 0;
        matches.forEach(match => {
            total += parseFloat(document.getElementById(match.totalId).value) || 0;
        });
        document.getElementById('Endtotal').value = total.toFixed(2);
    }

    window.saveAndClose = function() {
        const total = document.getElementById('Endtotal').value;
        document.getElementById('quantity').value = total;
        hideModal();
    };

    function calculateJobTotal() {
        const price = parseFloat(document.getElementById('price').value) || 0;
        const quantity = parseFloat(document.getElementById('quantity').value) || 0;
        const vat = parseFloat(document.getElementById('vat').value) || 0;
        const total = (price * quantity) + vat;
        document.getElementById('total_price').value = total.toFixed(2);
    }

    document.getElementById('price').addEventListener('input', calculateJobTotal);
    document.getElementById('quantity').addEventListener('input', calculateJobTotal);
    document.getElementById('vat').addEventListener('input', calculateJobTotal);
});
</script>
@endsection
