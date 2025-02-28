<template>
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <data-table
                        :columns="columns"
                        :dataSource="notification"
                        @limitChanged="
                            (limit) => {
                                getQueryLimit(limit);
                            }
                        "
                        @paginationChanged="
                            (page) => {
                                getNotifications(page);
                            }
                        "
                        @keywordSearched="
                            (keyword) => {
                                getSpecificNotification(keyword);
                            }
                        "
                    >
                        <template v-slot:tbody="{ item: { item, index } }">
                            <td
                                :class="{
                                    'new-email font-weight-bold':
                                        item.has_read == false,
                                }"
                            >
                                {{ index + 1 }}
                            </td>
                            <td
                                :class="{
                                    'new-email font-weight-bold':
                                        item.has_read == false,
                                }"
                            >
                                {{ item.created_at | billDate }}
                            </td>
                            <td
                                :class="{
                                    'new-email font-weight-bold':
                                        item.has_read == false,
                                }"
                            >
                                {{ item.title }}
                            </td>
                            <td
                                :class="{
                                    'new-email font-weight-bold':
                                        item.has_read == false,
                                }"
                            >
                                {{ item.body }}
                            </td>
                            <td
                                :class="{
                                    'new-email': item.has_read == false,
                                }"
                            >
                                <i
                                    v-show="!item.has_read"
                                    class="fas fa-star text-warning"
                                ></i>
                            </td>
                            <td
                                class="text-center"
                                :class="{
                                    'new-email': item.has_read == false,
                                }"
                            >
                                <i
                                    v-show="!item.has_read"
                                    @click="markEmailAsRead(item.id)"
                                    class="
                                        fas
                                        fa-check
                                        text-success
                                        icon-button
                                    "
                                ></i>
                                <i
                                    @click="deleteNotification(item.id)"
                                    class="fas fa-trash text-danger icon-button"
                                ></i>
                            </td>
                        </template>
                    </data-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            notification: {},

            limit: "",
            keyword: "",
            columns: [
                { name: "#", sortName: "id", sortVal: "asc", width: "5%" },
                {
                    name: "Date",
                    sortName: "created_at",
                    sortVal: "asc",
                    width: "10%",
                },
                {
                    name: "Title",
                    sortName: "title",
                    sortVal: "asc",
                    width: "20%",
                },
                { name: "Notification", width: "50%" },
                { name: "New", width: "5%" },
                { name: "Actions", width: "10%" },
            ],
        };
    },

    methods: {
        getQueryLimit(limit) {
            this.limit = limit;
            this.getNotifications();
        },

        getNotifications(page = 1) {
            axios
                .get("/api/notifications/system", {
                    params: {
                        page,
                        limit: this.limit,
                        keyword: this.keyword,
                    },
                })
                .then((response) => {
                    this.notification = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getSpecificNotification(keyword) {
            this.keyword = keyword;
            this.getNotifications();
        },

        deleteNotification(id) {
            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(`/api/notifications/system/${id}`)
                        .then((response) => {
                            if (response.status == 200) {
                                swal.fire(
                                    "Deleted!",
                                    response.data.message,
                                    "success"
                                );
                                this.getNotifications();
                            }
                        })
                        .catch((error) => {
                            swal.fire(
                                "Deleted!",
                                error.response.data.message,
                                "error"
                            );
                        });
                }
            });
        },

        markEmailAsRead(id) {
            axios
                .post(`/api/notifications/system/${id}/read`)
                .then((response) => {
                    if (response.status == 200) {
                        this.getNotifications();
                    }
                })
                .catch((error) => {
                    swal.fire("Opps, an error!", error.response.data.message, "error");
                });
        },
    },
};
</script>

<style lang="scss" scoped>
.new-email {
    background-color: #e2fad78f;
}
</style>
