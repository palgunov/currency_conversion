<template>
    <div>
        <v-alert
            type="success"
            v-if="sent"
        >
            Заявка отправлена
        </v-alert>
        <form
            v-if="!sent"
            @submit="onSubmit"
        >
            <v-text-field
                v-model="form.amount"
                type="number"
                required
                placeholder="Сумма, руб"
            />
            <v-select
                v-model="form.select"
                :items="items"
                label="Валюта для конвертации"
            />
            <v-alert
                border="right"
                color="blue-grey"
                dark
            >
                Сумма в валюте : {{calculation}}
            </v-alert>
            <v-text-field
                v-model="email"
                type="text"
                required
                placeholder="email"
                label="E-mail"
                :error-messages="emailErrors"
                @input="$v.email.$touch()"
                @blur="$v.email.$touch()"
            />
            <v-btn
                type="submit"
                :disabled="this.$v.$invalid"
            >
                
                Записаться на обмен валюты
            </v-btn>
        </form>
    </div>
</template>
<script>
const querystring = require("querystring");
import { validationMixin } from 'vuelidate'
import { required, email } from 'vuelidate/lib/validators'

export default ({
    mixins: [validationMixin],

    validations: {
      email: { required, email },
    },

    data() {
        return{
            sent:false,
            items:[],
            email:"",
            currency:[],
            sum:1,
            form:{
                amount:'',
                select:"null",
                currencyAmount: "",
                email: '',
            }
        }
        
    },
    mounted(){
        //получаем данные курсов валют
        this.axios.get('https://www.cbr-xml-daily.ru/daily_json.js')
            .then((res)=>{
                for(let CharCode in res.data.Valute){
                    let char = res.data.Valute[CharCode]
                    this.currency.push(res.data.Valute[CharCode])
                    this.items.push(char.Name)
                }
                console.log(res);
            })
    },    
    computed:{
        //обработка данных о валюте 
        calculation(){
            this.currency.forEach(el => {
                if(el.Name === this.form.select){
                    this.sum = el.Value/el.Nominal
                }
            });
            return Math.floor((this.form.amount / this.sum) * 100) / 100 
        },
        //валидация емейла
        emailErrors () {
            const errors = []
            if (!this.$v.email.$dirty) return errors
            !this.$v.email.email && errors.push('Должен быть действующий e-mail')
            !this.$v.email.required && errors.push('Введите email')
            return errors
      },
    },
    methods:{
        //отправка формы
        onSubmit(e){
            e.preventDefault();
            this.form.email = this.email
            this.form.currencyAmount = this.calculation
            this.axios
                .post(
                    "./mail.php",
                    querystring.stringify(this.form)
                ).then(()=>{
                    this.sent = true;
                })

        }
    }

})
</script>
