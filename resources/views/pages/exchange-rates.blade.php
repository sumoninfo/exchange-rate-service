@extends('layouts.app')
@section('title', 'Exchange rates')
@section('content')
    <h1>Exchange Rates</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Currency Name</th>
            <th>Rate (USD)</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="currency-table"></tbody>
    </table>
    <nav>
        <ul class="pagination" id="pagination-links"></ul>
    </nav>

    <!-- Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Currency Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Currency Name:</strong> <span id="currency-name"></span></p>
                    <p><strong>Rate (USD):</strong> <span id="currency-rate"></span></p>

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Rate</th>
                        </tr>
                        </thead>
                        <tbody id="currency-history"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        let token = window.localStorage.getItem('auth_token');

        function fetchCurrencies(page = 1) {
            fetch(`/api/currencies?page=${page}`, {
                headers: {'Authorization': `Bearer ${token}`}
            })
                .then(response => response.json())
                .then(({status, data}) => {
                    const tableBody = document.getElementById('currency-table');
                    tableBody.innerHTML = '';
                    
                    if (!status) {
                        return alert('Something wrong')
                    }

                    if (!data.data.length) {
                        return tableBody.innerHTML = '<tr><td class="fw-bold text-center" colspan="3">No Data Found</td></tr>'
                    }

                    data.data.forEach(currency => {
                        tableBody.innerHTML += `<tr>
                                                    <td>${currency.name}</td>
                                                    <td>${currency.rate}</td>
                                                    <td><button class="btn btn-primary" onclick="showDetails(${currency.id})">Details</button></td>
                                                </tr>`;
                    });
                    // Pagination links
                    const paginationLinks = document.getElementById('pagination-links');
                    paginationLinks.innerHTML = '';
                    if (data.links) {
                        data.links.forEach(link => {
                            // Only process valid URLs
                            if (link.url !== null) {
                                const pageNumber = new URL(link.url).searchParams.get('page');

                                paginationLinks.innerHTML += `<li class="page-item ${link.active ? 'active' : ''}">
                                                                    <a class="page-link" href="#" onclick="fetchCurrencies(${pageNumber})">${link.label}</a>
                                                                </li>`;
                            }
                        });
                    }
                })
                .catch((error) => {
                    window.location.href = '/'
                });
        }

        function showDetails(currencyId) {
            const historyTableBody = document.getElementById('currency-history');
            historyTableBody.innerHTML = '';
            fetch(`/api/currencies/${currencyId}`, {
                headers: {'Authorization': `Bearer ${token}`}
            })
                .then(response => response.json())
                .then(({status, data}) => {
                    if (!status) {
                        return alert('Something wrong')
                    }
                    document.getElementById('currency-name').innerText = data.name;
                    document.getElementById('currency-rate').innerText = data.rate;

                    data.histories.forEach(history => {
                        historyTableBody.innerHTML += `<tr>
                                                            <td>${new Date(history.created_at).toLocaleDateString()}</td>
                                                            <td>${history.rate}</td>
                                                        </tr>`;
                    });

                    // Show modal
                    var detailsModal = new bootstrap.Modal(document.getElementById('detailsModal'));
                    detailsModal.show();
                });
        }

        // Fetch the first page on load
        fetchCurrencies();
    </script>
@endsection
