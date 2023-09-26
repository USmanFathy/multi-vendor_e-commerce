{{--@if($errors->any())--}}
{{--    <div class="alert alert-danger">--}}
{{--        <h3>Error Occuerd!</h3>--}}
{{--        <ul>--}}
{{--            @foreach($errors->all() as $error)--}}
{{--                <li>{{$error}}</li>--}}
{{--            @endforeach--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--@endif--}}
<div class="form-group">
        <label for="">Category Name</label>
{{--    class="form-control @error('name') is-invalid @enderror"--}}
        <input type="text" name="name" @class([
        'form-control',
        'is-invalid'=>$errors->has('name')
]) value="{{old('name' , $category->name ) }}">
        @error('name')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Category parent</label>

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
        <label for="">Description</label>
        <textarea name="description" >{{old('description',$category->description)}}</textarea>
    </div>
    <div class="form-group">
        <label for="">Image</label>
        <input type="file" name="image" class="form-control" >
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
        <div class="form-group">
            <label for="">Status</label>
            <div class="form-check">

                <input type="radio" name="status" class="form-check-input" value="active" @checked(old('status' ,$category->status)   =='active' )>
                <label for="" class="form-check-label">Active</label>
            </div>
            <div class="form-check">
                <input type="radio" name="status" class="form-check-input" value="archived" @checked(old('status' ,$category->status)   =='archived' )>
                <label for="" class="form-check-label">Archived</label>
            </div>

            @error('status')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">{{$button_label}}</button>
        </div>
