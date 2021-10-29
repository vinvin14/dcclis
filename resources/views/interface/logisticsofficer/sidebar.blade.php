
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <div class="nav-link collapsed" data-toggle="collapse" data-target="#collapseIAR"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-boxes"></i>
        <span style="cursor: pointer" class="font-weight-bold">IAR</span>
</div>
    <div id="collapseIAR" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Options:</h6>
            <a class="collapse-item" href="{{ route('iar.logisticsOfficer.list') }}">IAR List</a>
            <a class="collapse-item" href="{{ route('iar.logisticsOfficer.create') }}">Create an IAR</a>
        </div>
    </div>
</li>

<!-- Nav Item - Pages Collapse Menu for end users -->
<li class="nav-item">
    <a class="nav-link" href="#" >
        <i class="fas fa-clipboard-check"></i>
        <span class="font-weight-bold">Request & Issuances Slip</span>
    </a>
</li>

<!-- Nav Item - Pages Collapse Menu for end users -->
<li class="nav-item">
    <a class="nav-link" href="#">
        <i class="fas fa-clipboard-list"></i>
        <span class="font-weight-bold">Allocation List</span>
    </a>
    {{-- <div id="collapseAllocation" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Options:</h6>
            <a class="collapse-item" href="cards.html">Allocation List</a>
            <a class="collapse-item" href="buttons.html">Create Allocation List</a>
        </div>
    </div> --}}
</li>


<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDelivery"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-truck-loading"></i>
        <span class="font-weight-bold">Delivery</span>
    </a>
    <div id="collapseDelivery" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Options:</h6>
            <a class="collapse-item" href="cards.html">Deliveries</a>
            <a class="collapse-item" href="buttons.html">Schedule a Delivery</a>
        </div>
    </div>
</li>
