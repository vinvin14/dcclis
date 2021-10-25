<!-- Nav Item - Pages Collapse Menu for end users -->
<li class="nav-item @if(@$page == 'ris') active @endif">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapaseRis"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-clipboard-check"></i>
        <span class="font-weight-bold">Request & Issuance</span>
    </a>
    <div id="collapaseRis" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Options:</h6>
            <a class="collapse-item" href="cards.html">Items for RIS</a>
            <a class="collapse-item" href="{{route('ris.list')}}">RIS List</a>
            <a class="collapse-item" href="buttons.html">Create RIS</a>
        </div>
    </div>
</li>

<!-- Nav Item - Pages Collapse Menu for end users -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAllocation"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-clipboard-list"></i>
        <span class="font-weight-bold">Allocation List</span>
    </a>
    <div id="collapseAllocation" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Options:</h6>
            <a class="collapse-item" href="cards.html">Allocation List</a>
            <a class="collapse-item" href="buttons.html">Create Allocation List</a>
        </div>
    </div>
</li>
