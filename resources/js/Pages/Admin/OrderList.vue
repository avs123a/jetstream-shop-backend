<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Orders
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert" v-if="$page.flash && $page.flash.message">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ $page.flash.message }}</p>
                            </div>
                        </div>
                    </div>

                    <table class="table-fixed w-full">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 w-20">Id</th>
                            <th class="px-4 py-2">User Name</th>
                            <th class="px-4 py-2">Created At</th>
                            <th class="px-4 py-2">Updated At</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="row in orders.data">
                            <td class="border px-4 py-2">{{ row.id }}</td>
                            <td class="border px-4 py-2">{{ row.user_name }}</td>
                            <td class="border px-4 py-2">{{ row.created_at }}</td>
                            <td class="border px-4 py-2">{{ row.updated_at }}</td>
                            <td class="border px-4 py-2">{{ row.status }}</td>
                            <td class="border px-4 py-2">
<!--                                <button @click="edit(row)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button>-->
                                <button @click="deleteById(row.id)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <pagination class="mt-6" :links="orders.links" />
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from './../../Layouts/AppLayout'
import Welcome from './../../Jetstream/Welcome'
import Input from "@/Jetstream/Input";
import Pagination from '@/Layouts/Pagination'

export default {
    components: {
        Input,
        AppLayout,
        Welcome,
        Pagination,
    },
    props: ['orders', 'errors'],
    data() {
        return {
            // editMode: false,
            // form: {
            //     title: null,
            //     slug: null,
            //     parent_id: null,
            //     enabled: null,
            // },
        }
    },
    methods: {

        // edit: function (data) {
        //     this.form = Object.assign({}, data);
        //     // this.editMode = true;
        //     this.openModal();
        // },
        // update: function (data) {
        //     data._method = 'PUT';
        //     this.$inertia.post('categories/' + data.id, data)
        //     this.reset();
        //     this.closeModal();
        // },
        finishById: function (orderId) {
            if (!confirm('Are you sure want to finish?')) return;
            data._method = 'PUT';
            this.$inertia.post('orders/' + orderId, {status: 2})
        },
        cancelById: function (orderId) {
            if (!confirm('Are you sure want to cancel?')) return;
            data._method = 'PUT';
            this.$inertia.post('orders/' + orderId, {status: 0})
        },
        deleteById: function (orderId) {
            if (!confirm('Are you sure want to remove?')) return;
            data._method = 'DELETE';
            this.$inertia.post('orders/' + orderId, {})
        }
    }
}
</script>
