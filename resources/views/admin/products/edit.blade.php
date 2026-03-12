<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit Product ') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#0f172a] min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1e293b] overflow-hidden shadow-2xl sm:rounded-3xl p-10 border border-gray-800">
                
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    {{-- Product Name --}}
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-2 ml-1">Product Name</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required 
                               class="block w-full bg-[#0f172a] border-gray-700 text-white rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-bold text-sm px-5 py-3.5 placeholder-gray-600 outline-none">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Category --}}
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-2 ml-1">Category</label>
                            <select name="category_id" required 
                                    class="block w-full bg-[#0f172a] border-gray-700 text-white rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-bold text-sm px-5 py-3.5 outline-none appearance-none">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Price --}}
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-2 ml-1">Price (₱)</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required 
                                   class="block w-full bg-[#0f172a] border-gray-700 text-white rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-bold text-sm px-5 py-3.5 placeholder-gray-600 outline-none">
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-2 ml-1">Description</label>
                        <textarea name="description" rows="4" required 
                                  class="block w-full bg-[#0f172a] border-gray-700 text-white rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-bold text-sm px-5 py-3.5 placeholder-gray-600 outline-none">{{ old('description', $product->description) }}</textarea>
                    </div>

                    {{-- Trending Checkbox --}}
                    <div class="flex items-center p-4 bg-[#0f172a] rounded-2xl border border-gray-700">
                        <input type="checkbox" name="is_trending" value="1" {{ $product->is_trending ? 'checked' : '' }} 
                               class="w-5 h-5 rounded border-gray-700 bg-transparent text-indigo-600 focus:ring-indigo-500 focus:ring-offset-0 transition">
                        <label class="ml-4 block text-xs text-gray-300 font-black uppercase tracking-widest">Mark as Trending 🔥</label>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="pt-4 flex flex-col md:flex-row gap-4">
                        <button type="submit" class="flex-1 flex justify-center py-5 px-4 border border-transparent rounded-2xl shadow-xl text-xs font-black uppercase tracking-[0.2em] text-white bg-indigo-600 hover:bg-indigo-500 transition-all transform active:scale-95 shadow-indigo-500/20">
                            Update Details
                        </button>
                        
                        <a href="{{ route('dashboard') }}" class="flex-1 flex justify-center py-5 px-4 border border-gray-700 rounded-2xl shadow-sm text-xs font-black uppercase tracking-[0.2em] text-gray-400 bg-transparent hover:bg-gray-800 hover:text-white transition-all transform active:scale-95">
                            Cancel Changes
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>