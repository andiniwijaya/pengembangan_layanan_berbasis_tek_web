@extends('layouts.admin')

@section('title', 'Customer')
@section('page-title', 'Kelola Customer')

@section('content')
@if($customers->isEmpty())
<x-empty-state icon="users" title="Belum Ada Customer" description="Customer yang mendaftar akan muncul di sini." />
@else
<div class="admin-table-wrap">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Pesanan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td class="font-medium">{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td class="text-text/70">{{ $customer->phone ?? '-' }}</td>
                    <td>{{ $customer->orders_count }}</td>
                    <td>
                        <x-icon-action icon="eye" tooltip="Detail Customer" :href="route('admin.customers.show', $customer)" />
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">{{ $customers->links() }}</div>
@endif
@endsection
