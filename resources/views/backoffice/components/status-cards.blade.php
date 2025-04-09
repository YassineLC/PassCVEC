<div class="d-flex justify-content-start mb-4 status-card-container">
    <div class="status-card status-green" data-filter="A traiter">
        <h3>{{ $incomingRequests ?? 0 }}</h3>
        <p>Demandes à traiter</p>
    </div>
    <div class="status-card status-orange" data-filter="En cours">
        <h3>{{ $pendingRequests ?? 0 }}</h3>
        <p>Demandes en cours</p>
    </div>
    <div class="status-card status-red" data-filter="Traité">
        <h3>{{ $assignedRequests ?? 0 }}</h3>
        <p>Demandes traités</p>
    </div>
</div>

@push('additional_js')
<script>
    document.querySelectorAll('.status-card').forEach(card => {
        card.addEventListener('click', function() {
            const filterValue = this.getAttribute('data-filter');
            const url = new URL(window.location.href);
            url.searchParams.set('statut', filterValue);
            
            // Conserver le paramètre rowsPerPage s'il existe
            const rowsPerPage = document.querySelector('select[name="rowsPerPage"]')?.value;
            if (rowsPerPage) {
                url.searchParams.set('rowsPerPage', rowsPerPage);
            }
            
            window.location.href = url.toString();
        });
    });
</script>
@endpush 