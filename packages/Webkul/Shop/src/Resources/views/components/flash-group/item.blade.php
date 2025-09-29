<v-flash-item
    v-for="flash in flashes"
    :key="flash.uid"
    :flash="flash"
    @onRemove="remove($event)"
/>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-flash-item-template"
    >
        <div
            class="alert"
            :class="{
                'alert-success': flash.type === 'success',
                'alert-danger': flash.type === 'error',
                'alert-warning': flash.type === 'warning',
                'alert-info': flash.type === 'info'
            }"
            role="alert"
            :style="typeStyles[flash.type]['container']"
        >
            <span
                :class="iconClasses[flash.type]"
                class="me-2"
                :style="typeStyles[flash.type]['icon']"
            ></span>

            <span class="flex-1">
                @{{ flash.message }}
            </span>

            <button
                type="button"
                class="btn-close"
                aria-label="Close"
                @click="remove"
            ></button>
        </div>
    </script>

    <script type="module">
        app.component('v-flash-item', {
            template: '#v-flash-item-template',

            props: ['flash'],

            data() {
                return {
                    iconClasses: {
                        success: 'fa fa-check-circle',
                        error: 'fa fa-times-circle',
                        warning: 'fa fa-exclamation-circle',
                        info: 'fa fa-info-circle',
                    },

                    typeStyles: {
                        success: {
                            container: 'background-color: #d4edda; color: #155724;',
                            icon: 'color: #155724'
                        },

                        error: {
                            container: 'background-color: #f8d7da; color: #721c24;',
                            icon: 'color: #721c24'
                        },

                        warning: {
                            container: 'background-color: #fff3cd; color: #856404;',
                            icon: 'color: #856404'
                        },

                        info: {
                            container: 'background-color: #e2e3e5; color: #383d41;',
                            icon: 'color: #383d41'
                        },
                    },
                };
            },

            created() {
                var self = this;

                setTimeout(function() {
                    self.remove();
                }, 5000);  // Automatically remove after 5 seconds
            },

            methods: {
                remove() {
                    this.$emit('onRemove', this.flash);
                }
            }
        });
    </script>
@endpushOnce
