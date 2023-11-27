@push('css')
    <link rel="stylesheet" href="{{asset('dist/css/tagify.css')}}">
@endpush
<div class="form-group">
    <x-form.label for="name">Product Name</x-form.label>
    <x-form.input name="name" :value="$product->name" />
    </div>
    <div class="form-group">
        <x-form.label for="product_id">Category Name</x-form.label>
    <select name="category_id" class="form-control form-select">
            <option value="">Primary Category</option>
    @foreach($categories as $category)
    <option value="{{$category->id}}" @selected(old('category_id' ,$product->category_id) ==$category->id ) >{{$category->name }}</option>
    @endforeach
    </select>
        @error('category_id')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <x-form.label for="description">Description</x-form.label>
        <x-form.textarea name="description" :value="$product->description"  />
    </div>
    <div class="form-group">
        <x-form.label for="image">Image</x-form.label>
        <x-form.input type="file" name="image" />
        @if($product->image )
            <img height="60" src="{{asset('storage/'.$product->image)}}">
        @endif
        @error('image')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
<div class="form-group">
    <x-form.label for="name">price</x-form.label>
    <x-form.input name="price" :value="$product->price" />
</div>
<div class="form-group">
    <x-form.label for="name">Compare Price</x-form.label>
    <x-form.input name="compare_price" :value="$product->compare_price" />
</div>
<div class="form-group">
    <x-form.label for="name">Tags</x-form.label>

    <x-form.input name="tags" :value="$tags"  />
</div>
<div class="form-group">
    <x-form.label for="status">Status</x-form.label>

    <x-form.checkbox  name="status" :options="['active' =>'Active' , 'draft'=>'Draft','archived' => 'Archived']" :checked="$product->status" />
</div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">{{$button_label}}</button>
        </div>

@push('js')
    <script src="{{asset('dist/js/tagify.min.js')}}"></script>
    <script src="{{asset('dist/js/tagify.polyfills.min.js')}}"></script>
    <script>
        var inputElm = document.querySelector('[name=tags]'),
            tagify = new Tagify (inputElm);
    </script>
@endpush
