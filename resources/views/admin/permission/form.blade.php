<div class="mb-3">
    <label for="">Название</label>
    <input class="form-control" type="text" name="title" placeholder="Название" value="{{old('title') ?? $permission->title ?? ''}}">
</div>

<div class="mb-3">
    <label for="">Префикс</label>
    <input class="form-control" type="text" name="name" placeholder="Префикс" value="{{old('name') ?? $permission->name ?? ''}}">
</div>

