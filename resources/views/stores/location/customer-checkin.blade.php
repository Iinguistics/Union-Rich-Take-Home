<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="mb-4">Customer Check In For {{ $location->location_name ?? null }}</h1>
                    <form method="post" action="{{ route('queueCustomerCheckin') }}">
                        @csrf
                        <input type="hidden" name="location_id" value={{ $location->id ?? null }}>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="firstName">
                                First Name
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="firstName" name="first_name" type="text" placeholder="First Name">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="lastName">
                                Last Name
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="lastName" name="last_name" type="text" placeholder="Last Name">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                Email
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="text" placeholder="Email">
                        </div>


                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        <div class="mb-4">
                            <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" type="submit">
                                Check In
                            </button>
                        </div>
                    </form>
                    <p class="bg-dark text-light mt-4">{{ session('queue-checkin-message') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
