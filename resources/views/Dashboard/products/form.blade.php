
<div class="form-group">
    <x-form.label for="name">Categorey Name</x-form.label>
    <x-form.input name="name" :value="$category->name" />
    </div>
    <div class="form-group">
        <x-form.label for="parent_id">Category Parent</x-form.label>

        <select name="parent_id" class="form-control form-select">
            <option value="">Primary Category</option>
@foreach($parents as $parent)
    <option value="{{$parent->id}}" @selected(old('parent_id' ,$category->parent_id) ==$parent->id ) >{{$parent->name }}</option>
    @endforeach
    </select>
        @error('parent_id')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <x-form.label for="description">Description</x-form.label>
        <x-form.textarea name="description" :value="$category->description"  />
    </div>
    <div class="form-group">
        <x-form.label for="image">Image</x-form.label>
        <x-form.input type="file" name="image" />
        @if($category->image )
            <img height="60" src="{{asset('storage/'.$category->image)}}">
        @endif
        @error('image')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
<div class="form-group">
    <x-form.label for="status">Status</x-form.label>

    <x-form.checkbox  name="status" :options="['active' =>'Active' , 'archived' => 'Archived']" :checked="$category->status" />
</div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">{{$button_label}}</button>
        </div>
