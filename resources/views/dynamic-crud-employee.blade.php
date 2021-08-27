<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Plugins -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Employee Dynamic CRUD</title>
  </head>
  <body>
    <div class="container my-5">
        <h1 class="text-center mb-5">Employee Dynamic CRUD</h1>
        <button class="btn btn-primary mb-4" onclick="onCreate()">Create Employee</button>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-primary">
                    <th>#</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Address</th>    
                    <th>Action</th>    
                </thead>
                <tbody id="tbody-employee">

                </tbody>
            </table>
        </div>
    </div>

    <!-- Form Modal -->
    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="form-action-submit">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" placeholder="name">
                        <div class="invalid-feedback d-none" id="invalid-feedback-name"></div>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                        <select class="form-select" id="gender">
                            <option selected disabled>Choose Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <div class="invalid-feedback d-none" id="invalid-feedback-gender"></div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" rows="3"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="form-button-submit" data-type="" onclick="submitData(this)">Save</button>
                </form>
            </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Plugins -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            loadDataEmployees();
        });
    </script>

    <script>
        function loadDataEmployees() {
            fetch('api/employees')
                .then((res) => res.json())
                .then((response) => {
                    let tbodyElement    = document.getElementById('tbody-employee');
                    let employees       = response.data;

                    tbodyElement.innerHTML = '';
                    employees.forEach((employee, index) => {
                        let rowEmployee = `<tr>
                                                <td>${index + 1}</td>
                                                <td>${employee.name}</td>
                                                <td>${employee.gender}</td>
                                                <td>${employee.address ? employee.address : '-'}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary" onclick="onEdit(${employee.id})">Edit</button>
                                                    <button class="btn btn-sm btn-danger" onclick="onDelete(${employee.id})">Delete</button>
                                                </td>
                                            </tr>
                                            `
                        tbodyElement.innerHTML += rowEmployee;
                    });

                }).catch((err) => {
                    throw err;
                })
        }

        function onEdit(employee_id) {
            const baseUrl   = window.location.origin;

            setFormActionAndButtonType(baseUrl + `/api/employees/${employee_id}`, 'update');

            let url         = getFormAction();
            fetch(url).then((res) => res.json())
                .then((response) => {
                    let data = response.data;
                    setInputValues({
                        name: data.name,
                        gender: data.gender,
                        address: data.address
                    });
                    showModal();
                }).catch((err) => {
                    throw err;
                })
        }

        function onCreate() {
            const baseUrl = window.location.origin;

            setFormActionAndButtonType(baseUrl + '/api/employees', 'store');
            showModal();
        }

        function onDelete(employee_id) {

            iziToast.question({
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Hey',
                message: 'Are you sure to delete employee?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', async function (instance, toast) {
                        let baseUrl = window.location.origin;

                        await fetch(baseUrl + '/api/employees/' + employee_id, {
                            method: 'DELETE',
                            headers: {'Content-Type': 'application/json'},
                        }).then((res) => res.json())
                        .then((response) => {
                            iziToast.success({
                                title: 'Successfully',
                                message: response.message,
                                position: 'center'
                            });
                            loadDataEmployees();
                        }).catch((err) => {
                            throw err;
                        });

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {
            
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            
                    }],
                ]
            });
        }       

        function submitData(buttonSubmitDataElement) {
            event.preventDefault();
            let url     = getFormAction();
            let type    = getFormButtonType();

            if( type == 'store' ) {
                fetch(url, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(getFormValues())
                }).then((res) => {
                    if( !res.ok ) {
                        if( res.status == 422 ) {
                            res.text().then((err) => {
                                let errorsObj = JSON.parse(err);

                                removeAllDisplayErrorTextMessages();
                                addAllDisplayErrorTextMessages(errorsObj.errors);
                            })
                        }
                        return false;
                    } else {
                        return res.json();
                    }
                }).then((response) => {
                    if( response != false ) {
                        removeAllDisplayErrorTextMessages();
                        removeAllInputValues();
                        hideModal();

                        iziToast.success({
                            title: 'Successfully',
                            message: 'inserted employee!',
                            position: 'center'
                        });

                        loadDataEmployees();
                    }
                    return;
                }).catch((err) => {
                    removeAllDisplayErrorTextMessages();
                    removeAllInputValues();
                    hideModal();
                    throw err;
                })
            } else if( type == 'update' ) {
                fetch(url, {
                    method: 'PUT',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(getFormValues())
                }).then((res) => {
                    if( !res.ok ) {
                        if( res.status == 422 ) {
                            res.text().then((err) => {
                                let errorsObj = JSON.parse(err);

                                removeAllDisplayErrorTextMessages();
                                addAllDisplayErrorTextMessages(errorsObj.errors);
                            })
                        }
                        return false;
                    } else {
                        return res.json();
                    }
                }).then((response) => {
                    if( response != false ) {
                        removeAllDisplayErrorTextMessages();
                        removeAllInputValues();
                        hideModal();

                        iziToast.success({
                            title: 'Successfully',
                            message: 'updated employee!',
                            position: 'center'
                        });
                        loadDataEmployees();
                    }
                    return;
                }).catch((err) => {
                    removeAllDisplayErrorTextMessages();
                    removeAllInputValues();
                    hideModal();
                    throw err;
                })
            }
        }
    </script>

    <script>
        // Helper Function
        function showModal() {
            const modalElement = new bootstrap.Modal(document.getElementById('formModal'));
            modalElement.show();
        }

        function hideModal() {
            const modalElement = bootstrap.Modal.getInstance(document.getElementById('formModal'));    
            modalElement.hide();
        }

        function setFormActionAndButtonType(url, type) {
            const formButtonSubmitElement   = document.getElementById('form-button-submit');
            const formActionSubmit          = document.getElementById('form-action-submit');

            formButtonSubmitElement.dataset.type = type;
            formActionSubmit.setAttribute('url', url);
        }

        function getFormAction() {
            const formActionSubmit = document.getElementById('form-action-submit');
            return formActionSubmit.getAttribute('url');
        }

        function getFormButtonType() {
            const formButtonSubmitElement = document.getElementById('form-button-submit');
            return formButtonSubmitElement.dataset.type;
        }

        function getFormValues() {
            const inputNameElement      = document.getElementById('name');
            const inputGenderElement    = document.getElementById('gender');
            const inputAddressElement   = document.getElementById('address');

            return {
                name: inputNameElement.value,
                gender: inputGenderElement.options[inputGenderElement.selectedIndex].value,
                address: inputAddressElement.value
            }
        }

        function removeAllDisplayErrorTextMessages() {
            const availableInputElementsNameMayHasError = ['name', 'gender'];
            
            availableInputElementsNameMayHasError.forEach((availableInputElementName) => {
                let availableInputElement                       = document.getElementById(availableInputElementName);
                let inputTextShowErroravailableInputElement     = document.getElementById(`invalid-feedback-${availableInputElementName}`);

                availableInputElement.classList.contains('is-invalid') ? availableInputElement.classList.remove('is-invalid') : '';
                !inputTextShowErroravailableInputElement.classList.contains('d-none') ? inputTextShowErroravailableInputElement.classList.add('d-none') : '';
            });
        }

        function removeAllInputValues() {
            const availableInputElementsNameMayHasError = ['name', 'gender', 'address'];

            availableInputElementsNameMayHasError.forEach((availableInputElementName) => {
                let availableInputElement                       = document.getElementById(availableInputElementName);

                availableInputElement.value = '';
                if( availableInputElementName == 'gender' ) {
                    availableInputElement.options[0].selected = 'selected';
                } 
            });

        }

        function addAllDisplayErrorTextMessages(errors) {
            for( key in errors ) {
                let inputElement                = document.getElementById(key);
                let inputTextShowErrorElement   = document.getElementById(`invalid-feedback-${key}`);
                let textError                   = errors[key];

                !inputElement.classList.contains('is-invalid') ? inputElement.classList.add('is-invalid') : '';
                inputTextShowErrorElement.classList.contains('d-none') ? inputTextShowErrorElement.classList.remove('d-none') : '';
                inputTextShowErrorElement.innerText = textError;
            }
        }

        function setInputValues(dataObj) {
            for( key in dataObj ) {
                let inputElement = document.getElementById(key);
                inputElement.value = dataObj[key];
            }
        }
    </script>
  </body>
</html>