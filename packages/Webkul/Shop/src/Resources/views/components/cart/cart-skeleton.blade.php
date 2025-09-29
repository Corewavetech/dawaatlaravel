<div class="container-fluid py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4 p-4">
                <div v-for="n in 3" :key="n" class="mb-4 d-flex shimmer-item">
                    <div class="shimmer-img rounded me-3"></div>
                    <div class="w-100">
                        <div class="shimmer-line w-75 mb-2"></div>
                        <div class="shimmer-line w-50 mb-2"></div>
                        <div class="shimmer-line w-100 mb-2"></div>
                        <div class="shimmer-line w-25 mb-2"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card p-4">
                <div class="shimmer-line w-50 mb-3"></div>
                <div class="shimmer-line w-100 mb-2"></div>
                <div class="shimmer-line w-100 mb-2"></div>
                <div class="shimmer-line w-75 mb-2"></div>
                <div class="shimmer-line w-100 mb-3"></div>
                <div class="shimmer-btn w-100"></div>
            </div>
        </div>
    </div>
</div>
