@props(['isMultiRow' => false])

<v-datagrid {{ $attributes }}>
    {{ $slot }}
</v-datagrid>

@pushOnce('scripts')
    <script type="text/x-template" id="v-datagrid-template">
        <div>
            <!-- Toolbar -->
            <x-admin::datagrid.toolbar />

            <div class="mt-4 flex">
                <x-admin::datagrid.table :isMultiRow="$isMultiRow">
                    <template #header="{
                        isLoading,
                        available,
                        applied,
                        selectAll,
                        sort,
                        performAction
                    }">
                        <slot
                            name="header"
                            :is-loading="isLoading"
                            :available="available"
                            :applied="applied"
                            :select-all="selectAll"
                            :sort="sort"
                            :perform-action="performAction"
                        >
                        </slot>
                    </template>

                    <template #body="{
                        isLoading,
                        available,
                        applied,
                        selectAll,
                        sort,
                        performAction
                    }">
                        <slot
                            name="body"
                            :is-loading="isLoading"
                            :available="available"
                            :applied="applied"
                            :select-all="selectAll"
                            :sort="sort"
                            :perform-action="performAction"
                        >
                        </slot>
                    </template>
                </x-admin::datagrid.table>
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-datagrid', {
            template: '#v-datagrid-template',

            props: ['src'],

            data() {
                return {
                    isLoading: false,

                    available: {
                        id: null,
                        columns: [],
                        actions: [],
                        massActions: [],
                        records: [],
                        meta: {},
                    },

                    applied: {
                        massActions: {
                            meta: {
                                mode: 'none',
                                action: null,
                            },
                            indices: [],
                            value: null,
                        },
                        pagination: {
                            page: 1,
                            perPage: 1, // Fixed per-page value of 1
                        },
                        sort: {
                            column: null,
                            order: null,
                        },
                        savedFilterId: null, // Remove filters
                    },
                };
            },

            watch: {
                'available.records': function (newRecords, oldRecords) {
                    this.setCurrentSelectionMode();
                    this.updateDatagrids();
                    this.updateExportComponent();
                },
            },

            mounted() {
                this.boot();
            },

            methods: {
                boot() {
                    let datagrids = this.getDatagrids();

                    const urlParams = new URLSearchParams(window.location.search);

                    if (urlParams.has('search')) {
                        let searchAppliedColumn = this.applied.filters.columns.find(column => column.index === 'all');
                        searchAppliedColumn.value = [urlParams.get('search')];
                    }

                    if (datagrids?.length) {
                        const currentDatagrid = datagrids.find(({ src }) => src === this.src);
                        if (currentDatagrid) {
                            this.applied.pagination = currentDatagrid.applied.pagination;
                            this.applied.sort = currentDatagrid.applied.sort;
                            this.applied.savedFilterId = currentDatagrid.applied.savedFilterId;
                            this.get();
                            return;
                        }
                    }

                    this.get();
                },

                get(extraParams = {}) {
                    let params = {
                        pagination: {
                            page: this.applied.pagination.page,
                            per_page: 1,  // Fetch only 1 record per page
                        },
                        sort: {},
                    };

                    const urlParams = new URLSearchParams(window.location.search);
                    urlParams.forEach((param, key) => params[key] = param);

                    this.isLoading = true;

                    this.$axios
                        .get(this.src, { params: { ...params, ...extraParams } })
                        .then((response) => {
                            const { id, columns, actions, mass_actions, records, meta } = response.data;

                            this.available.id = id;
                            this.available.columns = columns;
                            this.available.actions = actions;
                            this.available.massActions = mass_actions;
                            this.available.records = records;
                            this.available.meta = meta;

                            this.isLoading = false;
                        });
                },

                changePage(newPage) {
                    this.applied.pagination.page = newPage;
                    this.get();
                },

                changePerPageOption(option) {
                    this.applied.pagination.perPage = 1; // Keep perPage fixed to 1
                    if (this.available.meta.last_page >= this.applied.pagination.page) {
                        this.applied.pagination.page = 1;
                    }
                    this.get();
                },

                sort(column) {
                    if (column.sortable) {
                        this.applied.sort = {
                            column: column.index,
                            order: this.applied.sort.order === 'asc' ? 'desc' : 'asc',
                        };
                        this.applied.pagination.page = 1;
                        this.get();
                    }
                },

                setCurrentSelectionMode() {
                    this.applied.massActions.meta.mode = 'none';
                    if (!this.available.records.length) return;

                    let selectionCount = 0;
                    this.available.records.forEach(record => {
                        const id = record[this.available.meta.primary_column];
                        if (this.applied.massActions.indices.includes(id)) {
                            this.applied.massActions.meta.mode = 'partial';
                            ++selectionCount;
                        }
                    });

                    if (this.available.records.length === selectionCount) {
                        this.applied.massActions.meta.mode = 'all';
                    }
                },

                updateExportComponent() {
                    this.$emitter.emit('change-datagrid', {
                        available: this.available,
                        applied: this.applied
                    });
                },

                updateDatagrids() {
                    let datagrids = this.getDatagrids();
                    if (datagrids?.length) {
                        const currentDatagrid = datagrids.find(({ src }) => src === this.src);
                        if (currentDatagrid) {
                            datagrids = datagrids.map(datagrid => {
                                if (datagrid.src === this.src) {
                                    return {
                                        ...datagrid,
                                        requestCount: ++datagrid.requestCount,
                                        available: this.available,
                                        applied: this.applied,
                                    };
                                }
                                return datagrid;
                            });
                        } else {
                            datagrids.push(this.getDatagridInitialProperties());
                        }
                    } else {
                        datagrids = [this.getDatagridInitialProperties()];
                    }

                    this.setDatagrids(datagrids);
                },

                getDatagridsStorageKey() {
                    return 'datagrids';
                },

                getDatagrids() {
                    let datagrids = localStorage.getItem(this.getDatagridsStorageKey());
                    return JSON.parse(datagrids) ?? [];
                },

                setDatagrids(datagrids) {
                    localStorage.setItem(this.getDatagridsStorageKey(), JSON.stringify(datagrids));
                },
            },
        });
    </script>
@endPushOnce
