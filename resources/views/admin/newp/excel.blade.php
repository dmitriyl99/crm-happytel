<table>
    <thead>
        <tr>
            <th>Название</th>    
            <th>Тип платежа</th>
            <th>Дата создание</th>
            <th>Количество</th>
        </tr>
    </thead>
    <tbody>
    @foreach($entities as $item)
                            <tr>
                                <td>
                                    {{$item->listproduct->name ?? ''}}
                                </td>
                                <td>
                                    {{($item->setting->value ?? '')}}
                                </td>
                                <td>
                                    {{($item->created_at ?? '')}}
                                </td>
                                <td>
                                    {{($item->count ?? '')}}
                                </td>
                            </tr>
                            @endforeach
    </tbody>
</table>