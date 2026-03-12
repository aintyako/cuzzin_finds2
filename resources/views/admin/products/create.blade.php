<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Upload New Item ') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#0f172a] min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1e293b] overflow-hidden shadow-2xl sm:rounded-3xl p-10 border border-gray-800">
                
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    {{-- Product Name --}}
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-2 ml-1">Product Name</label>
                        <input type="text" name="name" required placeholder="e.g. Snatched Cargo Pants" 
                               class="block w-full bg-[#0f172a] border-gray-700 text-white rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-bold text-sm px-5 py-3.5 placeholder-gray-600 outline-none">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Category --}}
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-2 ml-1">Category</label>
                            <select name="category_id" required 
                                    class="block w-full bg-[#0f172a] border-gray-700 text-white rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-bold text-sm px-5 py-3.5 outline-none appearance-none">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Price --}}
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-2 ml-1">Price (₱)</label>
                            <input type="number" step="0.01" name="price" required placeholder="0.00" 
                                   class="block w-full bg-[#0f172a] border-gray-700 text-white rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-bold text-sm px-5 py-3.5 placeholder-gray-600 outline-none">
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-2 ml-1">Description</label>
                        <textarea name="description" rows="4" required placeholder="Tell them why they need this..." 
                                  class="block w-full bg-[#0f172a] border-gray-700 text-white rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-bold text-sm px-5 py-3.5 placeholder-gray-600 outline-none"></textarea>
                    </div>

                    {{-- Image Upload --}}
                    <div class="p-6 bg-[#0f172a] rounded-2xl border-2 border-dashed border-gray-700 hover:border-indigo-500 transition-colors group">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-3">Product Image Selection</label>
                        <input type="file" name="images[]" accept="image/*" multiple required
                               class="block w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 transition cursor-pointer">
                        <p class="mt-4 text-[10px] text-gray-500 font-medium">✨ Tip: Hold down <span class="text-gray-300 font-bold">Ctrl/Cmd</span> to upload multiple colors/angles.</p>
                    </div>

                    {{-- Trending Checkbox --}}
                    <div class="flex items-center p-4 bg-[#0f172a] rounded-2xl border border-gray-700">
                        <input type="checkbox" name="is_trending" value="1" class="w-5 h-5 rounded border-gray-700 bg-transparent text-indigo-600 focus:ring-indigo-500 focus:ring-offset-0">
                        <label class="ml-4 block text-xs text-gray-300 font-black uppercase tracking-widest">Mark as Trending 🔥</label>
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-4">
                        <button type="submit" class="w-full flex justify-center py-5 px-4 border border-transparent rounded-2xl shadow-xl text-xs font-black uppercase tracking-[0.2em] text-white bg-indigo-600 hover:bg-white hover:text-indigo-600 focus:outline-none transition-all transform active:scale-95 shadow-indigo-500/20">
                            Push to Catalog
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>