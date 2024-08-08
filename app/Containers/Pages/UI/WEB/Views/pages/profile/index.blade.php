<div class="space-y-2 flex flex-col lg:mx-auto lg:container">
    <div class="grid gap-2 grid-cols-1 xl:grid-cols-2">
        @include('pages::pages.profile.components.credentials')
        @include('pages::pages.profile.elements.statistics', ['statistics' => $statistics])
    </div>

    @include('pages::pages.profile.components.profileInvent')
</div>
