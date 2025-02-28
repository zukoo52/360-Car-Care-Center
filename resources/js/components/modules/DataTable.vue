<template>
    <div>
        <div class="row mb-3">
            <div class="col-4">
                <label for="">Search</label>
                <input
                    type="text"
                    class="form-control"
                    :placeholder="searchText"
                    v-model="keyword"
                    @keypress.enter="delaySearch"
                    @keyup="delaySearch"
                />
            </div>

            <div class="col-2 ml-auto">
                <label for="">Limit Results</label>
                <select
                    @change="emitLimit"
                    v-model="limit"
                    class="form-control"
                >
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="500">500</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th
                            v-for="(col, index) in columns"
                            :key="index"
                            class="inline-block"
                            :width="col.width"
                        >
                            <p class="inline">
                                {{ col.name }}
                                <span v-if="col.sortName">
                                    <span
                                        v-if="col.sortVal == 'asc'"
                                        @click="
                                            sortByColumn(
                                                col,
                                                col.sortName,
                                                'desc'
                                            )
                                        "
                                        class="fas fa-sort icon-button"
                                        style="cursor: pointer; font-size: 1em"
                                    ></span>
                                    <span
                                        v-else
                                        class="fas fa-sort icon-button"
                                        @click="
                                            sortByColumn(
                                                col,
                                                col.sortName,
                                                'asc'
                                            )
                                        "
                                        style="cursor: pointer; font-size: 1em"
                                    ></span>
                                </span>
                            </p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in items" :key="index">
                        <slot name="tbody" :item="{ item, index }"></slot>
                    </tr>
                </tbody>
            </table>
            <hr />
        </div>

        <div
            v-if="
                getPageNumbers(renderPages.startPage, renderPages.endPage)
                    .length > 1
            "
            class="d-flex justify-content-center"
        >
            <nav class="my-3">
                <ul class="pagination">
                    <li v-if="firstPage" class="page-item handpointer">
                        <a
                            class="page-link"
                            @click="paginationChanged(firstPage)"
                            >&lt;&lt; First Page</a
                        >
                    </li>
                    <li v-if="previousPage" class="page-item handpointer">
                        <a
                            class="page-link"
                            @click="paginationChanged(previousPage)"
                            >&lt; Previous</a
                        >
                    </li>
                    <li
                        v-for="i in getPageNumbers(
                            renderPages.startPage,
                            renderPages.endPage
                        )"
                        :key="i"
                        class="page-item handpointer"
                        :class="{ active: dataSource.current_page == i }"
                    >
                        <a class="page-link" @click="paginationChanged(i)">{{
                            i
                        }}</a>
                    </li>
                    <li v-if="nextPage" class="page-item handpointer">
                        <a
                            class="page-link"
                            @click="paginationChanged(nextPage)"
                            >Next &gt;</a
                        >
                    </li>
                    <li v-if="lastPage" class="page-item handpointer">
                        <a
                            class="page-link"
                            @click="paginationChanged(lastPage)"
                            >Last Page &gt;&gt;</a
                        >
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        searchText: {
            type: String,
            default: "Search...",
        },
        columns: {
            required: true,
            type: Array,
        },
        dataSource: {
            required: true,
        },
        maxPages: {
            default: 10,
        },
    },
    watch: {
        queryLimit(newValue) {
            localStorage.queryLimit = newValue;
        },
    },
    created() {
        if (localStorage.queryLimit) {
            this.limit = localStorage.queryLimit;
        }
        this.$emit("limitChanged", this.limit);
    },
    data() {
        return {
            limit: 50,
            keyword: "",
            sortName: "",
            sortVal: "",
        };
    },
    methods: {
        sortByColumn(col, sortName, sortVal) {
            col.sortVal = sortVal;
            this.sortName = sortName;
            this.sortVal = sortVal;
        },
        emitLimit() {
            this.$emit("limitChanged", this.limit);
            localStorage.setItem("queryLimit", this.limit);
        },
        paginationChanged(page) {
            this.$emit("paginationChanged", page);
        },
        delaySearch: _.debounce(function () {
            this.$emit("keywordSearched", this.keyword);
        }, 500),
        getPageNumbers: function (start, stop) {
            return new Array(stop - start + 1).fill(start).map((n, i) => n + i);
        },
    },
    computed: {
        items() {
            return _.orderBy(
                this.dataSource.data,
                [this.sortName],
                [this.sortVal]
            );
        },
        nextPage() {
            if (this.dataSource.next_page_url) {
                return Number(
                    new URL(this.dataSource.next_page_url).searchParams.get(
                        "page"
                    )
                );
            }
            return null;
        },
        previousPage() {
            if (this.dataSource.prev_page_url) {
                return Number(
                    new URL(this.dataSource.prev_page_url).searchParams.get(
                        "page"
                    )
                );
            }
            return null;
        },
        firstPage() {
            if (this.dataSource.first_page_url) {
                return Number(
                    new URL(this.dataSource.first_page_url).searchParams.get(
                        "page"
                    )
                );
            }
            return null;
        },
        lastPage() {
            if (this.dataSource.last_page_url) {
                return Number(
                    new URL(this.dataSource.last_page_url).searchParams.get(
                        "page"
                    )
                );
            }
            return null;
        },
        currentPage() {
            if (this.dataSource.current_page) {
                return this.dataSource.current_page;
            }
            return null;
        },
        renderPages() {
            if (this.lastPage > this.maxPages) {
                let maxPagesBeforeCurrentPage = Math.floor(this.maxPages / 2);
                let maxPagesAfterCurrentPage = Math.ceil(this.maxPages / 2) - 1;

                if (this.currentPage <= maxPagesBeforeCurrentPage) {
                    // current page near the start
                    return {
                        startPage: 1,
                        endPage: this.maxPages,
                    };
                } else if (
                    this.currentPage + maxPagesAfterCurrentPage >=
                    this.lastPage
                ) {
                    // current page near the end
                    return {
                        startPage: this.lastPage - this.maxPages + 1,
                        endPage: this.lastPage,
                    };
                } else {
                    // current page somewhere in the middle
                    return {
                        startPage: this.currentPage - maxPagesBeforeCurrentPage,
                        endPage: this.currentPage + maxPagesAfterCurrentPage,
                    };
                }
            } else {
                return {
                    startPage: this.firstPage,
                    endPage: this.lastPage,
                };
            }
        },
    },
};
</script>

<style lang="scss" scoped>
.handpointer {
    cursor: pointer;
}
.page-item:hover {
    background-color: #e9ecef !important;
}
</style>
