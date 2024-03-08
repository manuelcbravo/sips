<x-guest-layout>
    <!-- Content -->
    <div class="container-fluid px-3">
        <div class="row">
            <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center min-vh-lg-100 position-relative bg-light px-0">
                <div style="max-width: 23rem;">
                    <div class="text-center">
                        <img class="img-fluid" src="./assets/logos/logo.png" alt="Image Description" style="width: 12rem;" data-hs-theme-appearance="default">
                        <img class="img-fluid" src="./assets/logos/logo.png" alt="Image Description" style="width: 12rem;" data-hs-theme-appearance="dark">
                    </div>
                </div>
            </div>
            <!-- End Col -->

            <div class="col-lg-6 d-flex justify-content-center align-items-center min-vh-lg-100">
                <div class="w-100 content-space-t-4 content-space-t-lg-2 content-space-b-1" style="max-width: 25rem;">
                    <!-- Form -->
                    <form method="POST" action="{{ route('logincustom') }}" class="js-validate needs-validation" novalidate>
                        @csrf
                        <div class="text-center">
                            <div class="mb-5">
                                <h1 class="display-5">Iniciar sesión</h1>
                            </div>
                        </div>

                        <!-- Form -->
                        <div class="mb-4">
                            <label class="form-label" for="signinSrEmail">Correo electrónico</label>
                            <input type="email" class="form-control form-control-lg" name="email" id="signinSrEmail" tabindex="1" placeholder="email@address.com" aria-label="email@address.com" required>
                            <span class="invalid-feedback">Please enter a valid email address.</span>
                        </div>
                        <!-- End Form -->

                        <!-- Form -->
                        <div class="mb-4">
                            <label class="form-label w-100" for="signupSrPassword" tabindex="0">
                                <span class="d-flex justify-content-between align-items-center">
                                    <span>Password</span>
                                </span>
                            </label>

                            <div class="input-group input-group-merge" data-hs-validation-validate-class>
                                <input type="password" class="js-toggle-password form-control form-control-lg" name="password" id="signupSrPassword" placeholder="8+ characters required" aria-label="8+ characters required" required minlength="8" data-hs-toggle-password-options='{
                                   "target": "#changePassTarget",
                                   "defaultClass": "bi-eye-slash",
                                   "showClass": "bi-eye",
                                   "classChangeTarget": "#changePassIcon"
                                 }'>
                                <a id="changePassTarget" class="input-group-append input-group-text" href="javascript:;">
                                    <i id="changePassIcon" class="bi-eye"></i>
                                </a>
                            </div>

                            <span class="invalid-feedback">Please enter a valid password.</span>
                        </div>
                        <!-- End Form -->

                        <!-- Form Check -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                            <label class="form-check-label" for="rememeber">
                                Recuerdame
                            </label>
                        </div>
                        <!-- End Form Check -->

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg sisi">Ingresar</button>
                            <button class="btn btn-primary nono" style="display:none" type="button" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Cargando...
                            </button>
                        </div>

                    </form>
                    <!-- End Form -->
                </div>
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Content -->
</x-guest-layout>
