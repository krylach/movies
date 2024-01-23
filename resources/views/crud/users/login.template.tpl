{include file="{$template_dir}crud/header.{$suffix_template}.tpl"}
<div class="e-panel card col-md-6">
    <div class="card-body">
        <div class="card-title">
            <h6 class="mr-2"><span>Authorization:</span></h6>
        </div>
        <div class="e-table">
            <form class="form col-md-12" method="post" action="/login">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="email" name="email" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Password</label>
                            <input class="form-control" type="password" name="password" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button class="btn btn-md btn-primary" type="submit">Authorization</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{include file="{$template_dir}crud/footer.{$suffix_template}.tpl"}