<v-modal-confirm></v-modal-confirm>

@pushOnce('scripts')
    <script type="text/x-template" id="v-modal-confirm-template">
        <div>
            <!-- Backdrop -->
            <div
                class="modal-backdrop fade"
                :class="{ show: isOpen }"
                v-if="isOpen"
            ></div>

            <!-- Modal -->
            <div
                class="modal fade d-block"
                :class="{ show: isOpen }"
                v-if="isOpen"
                tabindex="-1"
                role="dialog"
                aria-modal="true"
                style="z-index: 1050;"
                @click.self="disagree"
            >
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">@{{ title }}</h5>
                            <button type="button" class="btn-close" aria-label="Close" @click="disagree"></button>
                        </div>
                        <div class="modal-body">
                            <p class="text-muted">@{{ message }}</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" @click="disagree">@{{ options.btnDisagree }}</button>
                            <button class="btn btn-primary" @click="agree">@{{ options.btnAgree }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-modal-confirm', {
            template: '#v-modal-confirm-template',

            data() {
                return {
                    isOpen: false,
                    title: '',
                    message: '',
                    options: {
                        btnDisagree: 'Cancel',
                        btnAgree: 'Confirm',
                    },
                    agreeCallback: null,
                    disagreeCallback: null,
                };
            },

            created() {
                this.registerGlobalEvents();
            },

            methods: {
                open({ title, message, options = {}, agree = () => {}, disagree = () => {} }) {
                    this.title = title;
                    this.message = message;
                    this.options = Object.assign(this.options, options);
                    this.agreeCallback = agree;
                    this.disagreeCallback = disagree;

                    this.isOpen = true;
                    document.body.style.overflow = 'hidden';
                },

                agree() {
                    this.isOpen = false;
                    document.body.style.overflow = 'auto';
                    if (this.agreeCallback) this.agreeCallback();
                },

                disagree() {
                    this.isOpen = false;
                    document.body.style.overflow = 'auto';
                    if (this.disagreeCallback) this.disagreeCallback();
                },

                registerGlobalEvents() {
                    this.$emitter.on('open-confirm-modal', this.open);
                },
            }
        });
    </script>

    
@endPushOnce
