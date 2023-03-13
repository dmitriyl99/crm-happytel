<div class="mb-3">
    <label for="">Название</label>
    <input class="form-control" type="text" name="name" placeholder="Название" value="{{old('title') ?? $role->name ?? ''}}">
</div>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Название</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($permissions as $key => $permission)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$permission->title}}</td>
            <td>
                <div class="form-check form-switch">
                    <input name="permissions[]" value="{{$permission->name}}" class="form-check-input" type="checkbox" id="permission{{$permission->id}}"
                    @if(isset($role) && $role->hasPermissionTo($permission->name)) checked @endif
                    >
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td>Нет данных для отображения</td>
        </tr>
        @endforelse
       
    </tbody>
</table>

