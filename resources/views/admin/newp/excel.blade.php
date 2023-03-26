<table>
    <thead>
        <tr>
            <th>Название</th>
            <th>Тип платежа</th>
            <th>Дата создание</th>
            <th>Количество</th>
            <th>Цена Продажи uzs</th>
            <th>Пользователь</th>
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
                                <td>{{ $item->listproduct->price_3 ?? ''}}</td>
                                <td>{{ $item->customer != null ? empty($item->customer->full_name) ? $item->customer->phone : $item->customer->full_name : $item->customer_id }}</td>
                            </tr>
                            @endforeach
    </tbody>
</table>
