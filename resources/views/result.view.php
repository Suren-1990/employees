<?php
includeView('partials.header');
?>

    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group btn-group-sm btn-delete-all-group" role="group">
                <button disabled="disabled" type="button" class="btn btn-danger btn-delete-all">Delete Selected</button>
                <button type="button" class="btn btn-success btn-add-new">Add new</button>
            </div>
            <div class="btn-group btn-group-sm search-form" role="group">
                <form action="/search" method="get" class="form-inline">
                    <input value="<?php echo $query ?>" type="text" class="form-control" name="q">
                    <button type="submit" class="input-group-addon btn btn-success cursor-pointer">Q</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row table-container">
        <div class="col-sm-12">
            <table class="table table-striped table-hover" id="employees">
                <thead>
                <tr>
                    <th><input class="select-all" type="checkbox"/></th>
                    <th>#</th>
                    <th>Full name</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>BankAccountNumber</th>
                    <th>CreditCardNumber</th>
                    <th>Phones</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($items as $value) : ?>
                    <tr>
                        <th>
                            <input data-email="<?php echo $value->email ?>" class="current-employer" type="checkbox"/>
                        </th>
                        <th scope="row"><?php echo ++$no; ?></th>
                        <th>
                            <p><?php echo $value->firstName; ?></p>
                            <p><?php echo $value->lastName; ?></p>
                            <p>Age: <?php echo $value->age; ?></p>
                        </th>
                        <th>
                            <p><?php echo $value->country; ?></p>
                            <p><?php echo $value->city; ?></p>
                        </th>
                        <th><?php echo $value->email; ?></th>
                        <th><?php echo $value->bankAccountNumber; ?></th>
                        <th><?php echo $value->creditCardNumber; ?></th>
                        <th>
                            <?php foreach ($value->phones as $phone) : ?>
                                <p><?php echo $phone; ?></p>
                            <?php endforeach; ?>
                        </th>
                        <th>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <button data-email="<?php echo $value->email ?>" type="button"
                                        class="btn btn-success btn-edit">Edit
                                </button>
                                <button data-email="<?php echo $value->email ?>" type="button"
                                        class="btn btn-danger btn-delete">Delete
                                </button>
                            </div>
                        </th>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!--Edit Modal-->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="updateForm">
                        <!--First Name-->
                        <div class="form-group row">
                            <label for="firstName" class="col-2 col-form-label">First Name</label>
                            <div class="col-10">
                                <input class="form-control" type="text" name="firstName" id="firstName">
                            </div>
                        </div>

                        <!--Last Name-->
                        <div class="form-group row">
                            <label for="lastName" class="col-2 col-form-label">Last Name</label>
                            <div class="col-10">
                                <input class="form-control" type="text" name="lastName" id="lastName">
                            </div>
                        </div>

                        <!--city-->
                        <div class="form-group row">
                            <label class="col-2 col-form-label">city</label>
                            <div class="col-10">
                                <input class="form-control" type="text" name="city">
                            </div>
                        </div>

                        <!--country-->
                        <div class="form-group row">
                            <label class="col-2 col-form-label">country</label>
                            <div class="col-10">
                                <input class="form-control" type="text" name="country">
                            </div>
                        </div>

                        <!--Age-->
                        <div class="form-group row">
                            <label for="age" class="col-2 col-form-label">Age</label>
                            <div class="col-10">
                                <input class="form-control" type="number" name="age" id="age">
                            </div>
                        </div>

                        <!--bankAccountNumber-->
                        <div class="form-group row">
                            <label for="bankAccountNumber" class="col-2 col-form-label">
                                Bank Account Number
                            </label>
                            <div class="col-10">
                                <input class="form-control" type="number" name="bankAccountNumber"
                                       id="bankAccountNumber">
                            </div>
                        </div>

                        <!--creditCardNumber-->
                        <div class="form-group row">
                            <label for="creditCardNumber" class="col-2 col-form-label">
                                Credit Card Number
                            </label>
                            <div class="col-10">
                                <input class="form-control" type="number" name="creditCardNumber"
                                       id="creditCardNumber">
                            </div>
                        </div>

                        <!--email-->
                        <div class="form-group row">
                            <label for="email" class="col-2 col-form-label">
                                Email
                            </label>
                            <div class="col-10">
                                <input class="form-control" type="email" name="email"
                                       id="email">
                            </div>
                        </div>

                        <!--Phones-->
                        <div class="form-group row">
                            <label class="col-2 col-form-label">
                                Phones
                            </label>
                            <div data-name="phones" class="col-10 phones">
                            </div>
                            <div class="col-12">
                                <button class="add-option btn btn-success btn-sm float-right">
                                    Add Option
                                </button>
                            </div>
                        </div>

                        <!--addresses-->
                        <div class="form-group row">
                            <label class="col-2 col-form-label">
                                Addresses
                            </label>
                            <div data-name="addresses" class="col-10 addresses">
                            </div>
                            <div class="col-12">
                                <button class="add-option btn btn-success btn-sm float-right">
                                    Add Option
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-update">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!--Add New-->
    <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add new</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="addNewForm">
                        <!--First Name-->
                        <div class="form-group row">
                            <label class="col-2 col-form-label">First Name</label>
                            <div class="col-10">
                                <input class="form-control" type="text" name="firstName">
                            </div>
                        </div>

                        <!--Last Name-->
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Last Name</label>
                            <div class="col-10">
                                <input class="form-control" type="text" name="lastName">
                            </div>
                        </div>

                        <!--city-->
                        <div class="form-group row">
                            <label class="col-2 col-form-label">city</label>
                            <div class="col-10">
                                <input class="form-control" type="text" name="city">
                            </div>
                        </div>

                        <!--country-->
                        <div class="form-group row">
                            <label class="col-2 col-form-label">country</label>
                            <div class="col-10">
                                <input class="form-control" type="text" name="country">
                            </div>
                        </div>

                        <!--Age-->
                        <div class="form-group row">
                            <label for="age" class="col-2 col-form-label">Age</label>
                            <div class="col-10">
                                <input class="form-control" type="number" name="age" id="age">
                            </div>
                        </div>

                        <!--bankAccountNumber-->
                        <div class="form-group row">
                            <label class="col-2 col-form-label">
                                Bank Account Number
                            </label>
                            <div class="col-10">
                                <input class="form-control" type="number" name="bankAccountNumber">
                            </div>
                        </div>

                        <!--creditCardNumber-->
                        <div class="form-group row">
                            <label class="col-2 col-form-label">
                                Credit Card Number
                            </label>
                            <div class="col-10">
                                <input class="form-control" type="number" name="creditCardNumber">
                            </div>
                        </div>

                        <!--email-->
                        <div class="form-group row">
                            <label class="col-2 col-form-label">
                                Email
                            </label>
                            <div class="col-10">
                                <input class="form-control" type="email" name="email">
                            </div>
                        </div>

                        <!--Phones-->
                        <div class="form-group row">
                            <label class="col-2 col-form-label">
                                Phones
                            </label>
                            <div data-name="phones" class="col-10 phones">
                            </div>
                            <div class="col-12">
                                <button class="add-option btn btn-success btn-sm float-right">
                                    Add Option
                                </button>
                            </div>
                        </div>

                        <!--addresses-->
                        <div class="form-group row">
                            <label class="col-2 col-form-label">
                                Addresses
                            </label>
                            <div data-name="addresses" class="col-10 addresses">
                            </div>
                            <div class="col-12">
                                <button class="add-option btn btn-success btn-sm float-right">
                                    Add Option
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-store">Save</button>
                </div>
            </div>
        </div>
    </div>
<?php
includeView('partials.footer');
?>