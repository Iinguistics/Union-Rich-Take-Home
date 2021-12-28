<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="mb-4">Select Store & Location for Customer Check In</h1>
                    <form method="post" action="{{ route('locationCheckin') }}">
                        @csrf
                        @if( is_iterable($stores) )
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="store">
                                Store
                            </label>
                            <select name="store_id" id="store">
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->store_name }}</option>
                                @endforeach
                        </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="location">
                                Location
                            </label>
                            <select name="location_id" id="location">
                            @foreach($stores as $store)
                             @foreach($store->locations as $location)
                                <option value="{{ $location->id }}">{{ $location->location_name}}</option>
                                 @endforeach
                                @endforeach
                        </select>
                        </div>
                        @endif

                        <div class="mb-4">
                            <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" type="submit">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
