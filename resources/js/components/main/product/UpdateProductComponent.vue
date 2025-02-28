<template>
    <div class=col-lg-12>
        <div v-if="$can('product_update')" class="row">
            <div class="col-12 mt-3">
                <div class="card">
                    <div
                            class="
                                card-header
                                d-flex
                                justify-content-between
                                align-items-center
                            "
                        >
                        <h4 class="card-title">Update Product Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form>
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="">Product Name</label><input
                                            type="text"
                                            v-model="form.name"
                                            class="form-control"
                                            placeholder="Type Product Name"
                                            id="productName"
                                            :class="{
                                                'is-invalid': form.errors.has('name'),
                                            }"
                                            />
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="">Manufacturer</label><input
                                            type="text"
                                            v-model="form.manufacturer"
                                            class="form-control"
                                            placeholder="Manufacturer"
                                            id="productManufacturer"
                                            :class="{
                                                'is-invalid': form.errors.has('manufacturer'),
                                            }"
                                            />
                                        </div>
                                        <div class="col-md-4 mb-3"><label for="">Manufacturing:</label>
                                            <select v-model="form.manufacturing" class="form-control" :class="{
                                                    'is-invalid': form.errors.has('manufacturing'),
                                                }" id="productManufacturing">
                                                <option value="In Manufacturing">In Manufacturing</option>
                                                <option value="Not In Manufacturing">Not In Manufacturing</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <div class="row-md-4 mb-3">
                                                <label for="">Total Quantity</label>
                                                <input
                                                    type="text"
                                                    v-model="form.total_quantity"
                                                    class="form-control"
                                                    placeholder="Total Quantity"
                                                    id="totalQuantity"
                                                    :class="{
                                                        'is-invalid': form.errors.has('total_quantity'),
                                                    }"
                                                />
                                            </div>
                                            <div class="row-md-2">
                                                <label for="">Cost per One</label>
                                            </div>
                                            <div class="row">
                                                <div class="input-group">
                                                    <label for="" class="col-form-label col-3">&nbsp;Rupees&nbsp;:</label>
                                                    <div class="col-9 mb-3">
                                                        <input
                                                        type="text"
                                                        v-model="form.cost_per_one"
                                                        class="form-control"
                                                        placeholder="Rs : 0.00"
                                                        id="costPerOne"
                                                        @blur="formatPrice"
                                                        :class="{
                                                            'is-invalid': form.errors.has('cost_per_one'),
                                                        }"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-md-2">
                                                <label for="">Price per One</label>
                                            </div>
                                            <div class="row">
                                                <div class="input-group">
                                                    <label for="" class="col-form-label col-3">
                                                        &nbsp;Rupees&nbsp;:
                                                    </label>
                                                    <div class="col-9 mb-3">
                                                        <input
                                                        type="text"
                                                        v-model="form.price_per_one"
                                                        class="form-control"
                                                        placeholder="Rs : 0.00"
                                                        id="pricePerOne"
                                                        @blur="formatPrice"
                                                        :class="{
                                                            'is-invalid': form.errors.has('price_per_one'),
                                                        }"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <div class="row-md-8 mb-3">
                                            <label for="">Description</label><textarea
                                                v-model="form.description"
                                                class="form-control"
                                                placeholder="Type Description about the product"
                                                id="productDescription"
                                                :class="{
                                                    'is-invalid': form.errors.has('description'),
                                                }"
                                                rows="9"
                                            ></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button
                                @click="updateProduct"
                                class="btn btn-primary"
                                :disabled="submit_disabled"
                                type="button"
                            >
                                Update
                            </button>
                            <button
                                @click="deleteProduct"
                                class="btn btn-danger"
                                :disabled="submit_disabled"
                                type="button"
                            >
                                Delete
                            </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["product"],
    created() {
this.form.id = this.product.id;
this.form.name = this.product.name;
this.form.manufacturer = this.product.manufacturer;
this.form.manufacturing = this.product.manufacturing;
this.form.total_quantity = this.product.total_quantity;
this.form.cost_per_one = this.product.cost_per_one;
this.form.price_per_one = this.product.price_per_one;
this.form.description = this.product.description;
    },
    mounted() {

    },
    data() {
        return {
            form: new Form({
            name: "",
            manufacturer: "",
            manufacturing: "",
            total_quantity: "",
            cost_per_one: "",
            price_per_one: "",
            description: ""
            }),
        };
    },
    methods: {
        updateProduct: async function () {
            try {
                Toast.fire({
                    icon: "info",
                    title: "Please wait!",
                });
                this.submit_disabled = true;
                const response = await this.form.patch(`/api/product/${this.product.id}/update`);
                if (response.status == 200){
                    Toast.fire({
                        icon: "success",
                        title: response.data.message,
                    }).then(() => {
                        this.submit_disabled = false;
                        window.location.href = "/product/view";
                    });
                }
            } catch (error) {
                console.log(error);
                this.submit_disabled = false;
            }
        },
        deleteProduct: async function () {
            try {
                Toast.fire({
                    icon: "info",
                    title: "Please wait!",
                });
                this.submit_disabled = true;
                const response = await this.form.patch(`/api/product/${this.product.id}/delete`);
                if (response.status == 200){
                    Toast.fire({
                        icon: "success",
                        title: response.data.message,
                    }).then(() => {
                        this.submit_disabled = false;
                        window.location.href = "/product/view";
                    });
                }
            } catch (error) {
                console.log(error);
                this.submit_disabled = false;
            }
        },
        formatPrice() {
            if (this.form.cost_per_one !== '') {
                this.form.cost_per_one = parseFloat(this.form.cost_per_one).toFixed(2);
            }if (this.form.price_per_one !== '') {
                this.form.price_per_one = parseFloat(this.form.price_per_one).toFixed(2);
            }
        }
    },
    computed: {
    },
};
</script>
