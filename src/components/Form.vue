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
            />
            <v-btn
                type="submit"
            >
                
                Записаться на обмен валюты
            </v-btn>
        </form>
    </div>
</template>
<script>


export default ({
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
        }
    },

})
</script>
