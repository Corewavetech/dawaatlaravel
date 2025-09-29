@php
    $customer = auth()->guard('customer')->user();    
@endphp

@push('styles')
    <style>
        .label-pending {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 0.75rem;
            font-weight: 600;
            color: #000;
            background-color: #eab308; /* Tailwind yellow-500 */
            border-radius: 0.2rem;
            text-align: center;
            white-space: nowrap;
        }

        .label-processing {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 0.75rem;
            font-weight: 600;
            color: #fff;
            background-color: #0891b2; /* Tailwind cyan-600 */
            border-radius: 0.2rem;
            text-align: center;
            white-space: nowrap;
        }

        .label-delivered {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 0.75rem;
            font-weight: 600;
            color: #fff;
            background-color: #22c55e; /* Tailwind green-500 */
            border-radius: 0.2rem;
            text-align: center;
            white-space: nowrap;
        }

        .label-cancelled {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 0.75rem;
            font-weight: 600;
            color: #fff;
            background-color: #ef4444; /* Tailwind red-500 */
            border-radius: 0.2rem;
            text-align: center;
            white-space: nowrap;
        }

        .label-shipping {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 0.75rem;
            font-weight: 600;
            color: #fff;
            background-color: #0ea5e9; /* Tailwind sky-500 */
            border-radius: 0.2rem;
            text-align: center;
            white-space: nowrap;
        }

        .label-out-of-delivery {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 0.75rem;
            font-weight: 600;
            color: #000;
            background-color: #facc15; /* Tailwind amber-400 */
            border-radius: 0.2rem;
            text-align: center;
            white-space: nowrap;
        }

    </style>
@endpush

<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.orders.title')
    </x-slot>

    <section>
        <div class="container-fluid">

            <!------ Include the above in your HEAD tag ---------->

            <div class="py-5">
                <div class="card profile_setion">

                    <div class="row">

                        <div class="col-md-3 ">
                            <div class="list-group ">
                                <div class="show_profile_data">
                                    <img
                                        src="{{ $customer->image_url ?? asset('uploads/avatar.jpg') }}" />
                                    <h5>{{ $customer->first_name." ".$customer->last_name }}</h5>
                                    {{-- <p>rohini sectior 7 new delhi </p> --}}
                                </div>
                                <a href="{{ route('shop.customers.account.profile.index') }}" class="list-group-item list-group-item-action "><i
                                        class="fa-regular fa-user mr-2"></i> Profile</a>
                                <a href="{{ route('shop.customers.account.orders.index') }}" class="list-group-item list-group-item-action active"><i
                                        class="fa-solid fa-cart-arrow-down mr-2"></i></i> My Orders</a>
                                <!-- <a href="/wishlist.html" class="list-group-item list-group-item-action">Wishlist</a> -->
                                <a href="{{ route('shop.customers.account.addresses.index') }}" class="list-group-item list-group-item-action"><i
                                        class="fa-solid fa-location-dot mr-2"></i></i> Save Address</a>
                                <a href="{{ route('shop.customers.account.support') }}" class="list-group-item list-group-item-action"><i
                                        class="fa-solid fa-headphones mr-2"></i> Help &
                                    Support</a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card border-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <form action="{{ route('shop.customer.session.destroy') }}" method="POST" id="customerLogout">
                                            @csrf
                                            @method('DELETE')
                                            </form>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <h4>My Orders</h4>
                                                <a 
                                                    href="{{ route('shop.customer.session.destroy') }}" 
                                                    onclick="event.preventDefault(); document.getElementById('customerLogout').submit();"
                                                    class="btn btn-outline-danger">
                                                    Logout
                                                </a>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 mx-auto">

                                            <table class="table table-hover align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Order ID</th>
                                                        <th>Order Date</th>
                                                        <th>Total</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="orders-table-body">
                                                    
                                                </tbody>
                                            </table>

                                            <!-- Pagination -->
                                            <div class="d-flex justify-content-end">
                                                <nav>
                                                <ul class="pagination mb-0">
                                                    <li class="page-item disabled"><a class="page-link">&lt;</a></li>
                                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                                    <li class="page-item"><a class="page-link" href="#">&gt;</a></li>
                                                </ul>
                                                </nav>
                                            </div>

                                            <div class="mt-2">
                                                <small>Showing 1 to 5 of 5 entries</small>
                                            </div>                                            
                                            
                                            {{-- <div class="paginations mt-2">
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination">
                                                        <li class="page-item">
                                                            <a class="page-link" href="#" aria-label="Previous">
                                                                <span aria-hidden="true">&laquo;</span>
                                                            </a>
                                                        </li>
                                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                        <li class="page-item">
                                                            <a class="page-link" href="#" aria-label="Next">
                                                                <span aria-hidden="true">&raquo;</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </nav>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                axios.get('{{route('shop.customers.account.orders.index')}}')
                    .then(response => {                        

                        const orders = response.data.records;                        
                        console.log(response);         

                        renderTableData(response.data.records);
                        
                        renderPagination(response.data.meta);
                        updateShowingText(response.data.meta); 
                    })
                    .catch(error => {
                        console.error('Error fetching orders:', error);
                    });
            });

            function loadPage(page = 1) {
                $.ajax({
                    url: `{{route('shop.customers.account.orders.index')}}`,
                    method: 'GET',
                    success: function (response) {
                                                
                        renderTableData(response.data.records);
                        
                        renderPagination(response.meta);
                        updateShowingText(response.meta); 
                    },
                    error: function () {
                        alert('Failed to load data. Please try again.');
                    }
                });
            }

            function renderTableData(data) {
                const tbody = document.querySelector('#orders-table-body');
                tbody.innerHTML = '';

                data.forEach(row => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${row.id}</td>
                            <td>${row.created_at}</td>
                            <td>${row.grand_total}</td>
                            <td>${row.status}</td>
                            <td><a title="${row.actions[0].title}" href="${row.actions[0].url}"> <i class="fa fa-eye"></i></a></td>
                        </tr>
                    `;
                });
            }

            function updateShowingText(meta) {
                const from = meta.from ?? 0;
                const to = meta.to ?? 0;
                const total = meta.total ?? 0;
                const text = `Showing ${from} to ${to} of ${total} entries`;
                document.querySelector('.mt-2 small').textContent = text;
            }

            function renderPagination(meta) {
                const currentPage = meta.current_page ?? 1;
                const lastPage = meta.last_page ?? 1;

                let html = '';

                html += `
                    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${currentPage - 1}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>`;

                for (let i = 1; i <= lastPage; i++) {
                    html += `
                        <li class="page-item ${i === currentPage ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>`;
                }

                html += `
                    <li class="page-item ${currentPage === lastPage ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${currentPage + 1}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>`;

                document.querySelector('.paginations .pagination').innerHTML = html;

                document.querySelectorAll('.paginations .pagination a').forEach(link => {
                    link.addEventListener('click', function (e) {
                        e.preventDefault();
                        const page = parseInt(this.getAttribute('data-page'));
                        if (!isNaN(page)) {
                            loadPage(page);
                        }
                    });
                });
            }


        </script>
    @endpush

</x-shop::layouts.account>
