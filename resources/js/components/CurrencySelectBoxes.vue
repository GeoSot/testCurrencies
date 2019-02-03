<template>
    <div class="container my-5">
        <form class="" :action="action" method="post" @submit.prevent="submitForm">
            <div class="d-flex flex-wrap justify-content-center">
                <div class="form-group m-2 flex-column">
                    <label for="currency" class="d-block">Currencies</label>
                    <select class="custom-select" id="currency" @change="onChange" v-model="form.selected_coin"
                            :disabled="isProcessing()">
                        <option value="">-- --</option>
                        <option v-for="coin in currencies" :value="coin.code" :key="coin.code">
                            {{coin.name}}
                        </option>
                    </select>
                </div>
                <div class="form-group m-2 flex-column">
                    <label for="exchange_to" class="d-block">Available Exchanges</label>
                    <select class="custom-select" id="exchange_to" v-model="form.exchange_to"
                            :disabled="isProcessing()">
                        <option value="">-- --</option>
                        <option v-show="!isHidden(coin)" v-for="coin in availableExchanges" :value="coin.code">
                            {{coin.name}}
                        </option>
                    </select>
                </div>
                <div class="form-group m-2 flex-column">
                    <label for="amount" class="d-block">Amount</label>
                    <input type="number" class="form-control" id="amount" placeholder="Enter A Numeric Value"
                           :disabled="isProcessing()" v-model="form.amount">
                </div>
            </div>
            <div class="text-center my-2">
                <button type="submit" :disabled="disableBtn" class=" btn btn-primary ">{{btnText}}</button>
            </div>
            <div class="mt-4 py-2 px-4 alert " :class="msgClass" v-html="this.result.text"></div>
        </form>
    </div>
</template>


<script>
    export default {
        props: ['currencies', 'availableExchanges', 'action'],
        data: function () {
            return {
                form: {
                    selected_coin: '',
                    exchange_to: '',
                    amount: ''
                },
                result: {
                    text: ''
                },
                status: ''
            }
        }, methods: {
            isHidden($el) {
                let selected = this.currencies.find(it => it.code === this.form.selected_coin);
                return (!selected) ? false : !selected.available_exchanges.map(a => a.code).includes($el.code);
            },
            onChange() {
                this.form.exchange_to = '';
            },
            isProcessing() {
                return (this.status.toLowerCase() === 'processing');
            },

            submitForm(e) {
                this.status = 'processing';
                this.$http.post(this.action, this.form)
                    .then(response => {
                        this.result.text = response.data;
                        this.status = 'hasAnswer'
                    }).catch((error) => {
                    this.status = 'error';
                    let parser = new this.errorParser(error);
                    this.result.text = parser.message;
                    console.log(error);
                });
            }
        },
        computed: {

            disableBtn() {
                for (let key in this.form) {
                    if (this.form[key] === '') {
                        return true;
                    }
                }
                return this.isProcessing();
            },
            btnText() {
                return this.isProcessing() ? 'Processing' : 'Calculate';
            },
            msgClass() {
                if (this.isProcessing()) {
                    return ''
                }
                if (this.status === 'error') {
                    return 'alert-danger';
                }
                if (this.status === 'hasAnswer') {
                    return 'alert-info';
                }
                return '';
            }
        },
        mounted() {

        }
    }
</script>
