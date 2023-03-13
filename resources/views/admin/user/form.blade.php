<div class="mb-3">
    <label for="">ФИО</label>
    <input class="form-control" type="text" name="name" placeholder="ФИО" value="{{old('name') ?? $user->name ?? ''}}" required>
</div>

<div class="mb-3">
    <label for="">Логин</label>
    <input class="form-control" type="text" name="email" placeholder="Логин" value="{{old('email') ?? $user->email ?? ''}}" required>
</div>

<div class="mb-3">
    <label for="">Пароль 
        @isset($user->id) 
        (<i>Если вы хотите обновить пароль, вы можете ввести новый пароль </i>)      
        @endisset
    </label>
    <input class="form-control" type="password" name="password" placeholder="Пароль" value="" >
</div>
<div class="mb-3">
    <label for="">Подтвердить пароль</label>
    <input class="form-control" type="password" name="password_confirmation" placeholder="Подтвердить пароль" value="">
</div>
<div class="mb-3">
    <label for="">Роль</label>
    <select name="role" class="form-control" required>
        <option value="" disabled selected>Выбирать</option>
        <option value="super_admin" @if(isset($user) && $user->role == 'super_admin') selected @endif>Супер админ</option>
        <option value="admin"  @if(isset($user) && $user->role == 'admin') selected @endif>Админ</option>
        <option value="agent" @if(isset($user) && $user->role == 'agent') selected @endif>Агент</option>
        <option value="user" @if(isset($user) && $user->role == 'user') selected @endif>User</option>
        
    </select>
</div>

<div class="mb-3">
    <label for="">Агент</label>
    <select name="agent_id" class="form-control">
        <option value="" disabled selected>Выбирать</option>
        @foreach($agents as $item)
        <option value="{{$item->id}}" @if(isset($user) && $user->agent_id == $item->id) selected @endif>{{$item->title}}</option>
        @endforeach
    </select>
</div>

