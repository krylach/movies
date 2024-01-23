<form action="" method="get">
    <div>
        <div class="form-group">
            <label>Search by Title:</label>
            <div><input class="form-control w-100" type="text" placeholder="Name" name="title" value="{$filter.title}"></div>
        </div>
        <div class="form-group">
            <label>Search by Actor name:</label>
            <div><input class="form-control w-100" type="text" placeholder="Name" name="star" value="{$filter.star}"></div>
        </div>
    </div>
    <hr class="my-3">
    <div class="">
        <label>Sort by title:</label>
        <div class="px-2">
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" {if $request->query->get('sort') === 'ASC'} checked {/if} value="ASC" name="sort" id="users-status-disabled">
                <label class="custom-control-label" for="users-status-disabled">ASC</label>
            </div>
        </div>
        <div class="px-2">
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" {if $request->query->get('sort') === 'DESC'} checked {/if} value="DESC" name="sort" id="users-status-active">
                <label class="custom-control-label" for="users-status-active">DESC</label>
            </div>
        </div>
    </div>
    <div class="my-3">
        <button class="btn btn-success btn-block" type="submit" data-target="#user-form-modal">Search</button>
    </div>
</form>