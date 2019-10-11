<template>
	<v-content>
		<v-container fluid fill-height>
			<v-layout justify-center row>
				<v-flex xs12>
					<v-card>
						<v-toolbar flat color="white">
							<!-- <v-toolbar-title>Invoice Generate</v-toolbar-title>
							<v-divider class="mx-2" inset vertical></v-divider> -->
							Your area: {{dataArea.name}}
							<v-spacer></v-spacer>
							<v-btn color="primary"  small @click="goCustomer">Customers</v-btn>
							<v-btn color="error"  small v-show="dataList.length" @click="generateInvoice">Create</v-btn>
						</v-toolbar>
							<v-card-title>
								<v-layout  column wrap>
									<v-flex xs12>
                                        <v-autocomplete

                                            v-model="filterValue.customer"
                                            :items="filterData"
                                            item-text="customer_id"
                                            item-value="id"
                                            label="Customer ID"
                                            box
                                            @change="getBill"
                                        >
                                        <template v-slot:item="{ item }">
                                            <v-list-tile-avatar
                                            color="indigo"
                                            class="headline font-weight-light white--text"
                                            >
                                            {{ item.name.charAt(0) }}
                                            </v-list-tile-avatar>
                                            <v-list-tile-content>
                                            <v-list-tile-title v-text="item.name"></v-list-tile-title>
                                            <v-list-tile-sub-title v-text="item.contact"></v-list-tile-sub-title>
                                            </v-list-tile-content>
                                        </template>
                                        </v-autocomplete>
									</v-flex>
									<v-flex xs12> 
                                        <v-autocomplete
                                            v-model="filterValue.customer"
                                            :items="filterData"
                                            item-text="name"
                                            item-value="id"
                                            label="Customer Name"
                                            box
                                            @change="getBill"

                                        >
                                        <template v-slot:item="{ item }">
                                            <v-list-tile-avatar
                                            color="indigo"
                                            class="headline font-weight-light white--text"
                                            >
                                            {{ item.name.charAt(0) }}
                                            </v-list-tile-avatar>
                                            <v-list-tile-content>
                                            <v-list-tile-title v-text="item.name"></v-list-tile-title>
                                            <v-list-tile-sub-title v-text="item.address"></v-list-tile-sub-title>
                                            </v-list-tile-content>
                                        </template>
                                        </v-autocomplete>
									</v-flex>
									<v-flex xs12>
                                        <v-autocomplete
                                            v-model="filterValue.customer"
                                            :items="filterData"
                                            item-text="contact"
                                            item-value="id"
                                            label="Customer Number"
                                            box
                                            @change="getBill"
                                        >
                                        <template v-slot:item="{ item }">
                                            <v-list-tile-avatar
                                            color="indigo"
                                            class="headline font-weight-light white--text"
                                            >
                                            {{ item.name.charAt(0) }}
                                            </v-list-tile-avatar>
                                            <v-list-tile-content>
                                            <v-list-tile-title v-text="item.name"></v-list-tile-title>
                                            <v-list-tile-sub-title v-text="item.contact"></v-list-tile-sub-title>
                                            </v-list-tile-content>
                                        </template>
                                        </v-autocomplete>
									</v-flex>
								</v-layout>
							</v-card-title>
							<v-card-text>
								<v-layout align-center justify-center row fill-height v-show="dataList.length" >
      								<v-flex xs6>
		  								<span class="subheading">Total Amount: <b>{{editedItem.total_amount}} {{dataSetting.currency}}</b></span>
      								</v-flex>
      								<v-flex xs6>
		  								<span class="subheading">Total Bill: <b>{{editedItem.total_bill}}</b></span>
      								</v-flex>
								</v-layout>
								<v-data-table 
								:pagination.sync="pagination"
								v-show="dataList.length" 
								:headers="headers"
								:items="dataList"
								:search="search">
								<template v-slot:items="props">
									<td>{{ props.item.id }}</td>
									<td>{{ props.item.year }}</td>
									<td>{{ dataMonth[props.item.month-1].name }}</td>
									<td>{{ props.item.package_data.name }}</td>
									<td>{{ props.item.price }} {{dataSetting.currency}}</td>
								</template>
								<template v-slot:no-data>
									Please select customer
								</template>
							</v-data-table>
						</v-card-text>
					</v-card>
				</v-flex>
			</v-layout>
		</v-container>

		<v-snackbar
			v-model="snackbar"
			:multi-line="'multi-line'"
			:right="x === 'right'"
			:timeout="timeout=5000"
			:top="y === 'top'"
			:vertical="'vertical'"
			:color="snackBarColor"
		>
			{{ text }}
			<v-btn flat @click="snackbar = false">Close</v-btn>
		</v-snackbar>
	</v-content>
</template>

<script>

export default {
	data: () => ({
		pagination:{
			rowsPerPage: 25 // -1 for All",
		},
        loading: false,
        filterValue:
        {
            year:'',
            month:''
		},
		dataArea:{},
        dataYear:[

        ],
        dataMonth:[
            {
                id: 1,
                name: 'January'
            },
            {
                id: 2,
                name: 'February'
            },
            {
                id: 3,
                name: 'March'
            },
            {
                id: 4,
                name: 'April'
            },
            {
                id: 5,
                name: 'May'
            },
            {
                id: 6,
                name: 'June'
            },
            {
                id: 7,
                name: 'July'
            },
            {
                id: 8,
                name: 'Auguest'
            },
            {
                id: 9,
                name: 'September'
            },
            {
                id: 10,
                name: 'October'
            },
            {
                id: 11,
                name: 'November'
            },
            {
                id: 12,
                name: 'December'
            },

        ],
		snackBarColor:'green',
		isDelete:false,
		isDeleteAll:false,
		dataIndex:null,
		deleteTitle:'',
		deleteBody:'',
        search:'',
        dataList:[],
        dataPackages:[],
        dataCustomer:[],
		selected: [],
		snackbar: false,
		y: "top",
		x: null,
		mode: "",
		text: "Hello, I'm a snackbar",
		edit: true,
		dialog: false,
        dataList: [],
        items: ['Foo', 'Bar', 'Fizz', 'Buzz'],
		headers: [
			{ text: "ID", align: "left", value: "customer_id" },
			{ text: "Year", value: "year" },
			{ text: "Month", value: "month" },
			{ text: "Package", value: "package" },
			{ text: "Bill Amount", value: "price" },
		],
		dataSetting:{},
		editedIndex: -1,
		editedItem: {
			customer_id: "",
			bills:[],
			total_amount:0,
			total_bill:0
		},
		defaultItem: {
			customer_id: "",
			bills:[],
		}
	}),
	props: {
		source: String
	},

	computed: {
		filterData()
            {
                return this.dataCustomer.filter((data)=>{
                    
					return data.bill.length;
                }
                );
            },
	},

	watch: {},

	created() {
        this.initialize();
        var d = new Date();
        var year = d.getFullYear();
        for(let i=1;i<=100;i++)
        {
            
            this.dataYear.push(year)
            year++;
        }
	},

	methods: {
		goCustomer()
		{
			this.$router.push('/collector/customerlist')

		},
        async getBill(e)
        {

            try {
				let { data } = await axios({
					method: "get",
					url: "/app/customerbill/"+e
				});
				this.dataList = data;
				this.editedItem.customer_id=e
				this.editedItem.bills=data
				var totalAmount=0;
				var totalItem=0;
				for(let d of data)
				{
						console.log(totalItem)
					totalAmount=totalAmount+d.price
					totalItem++
					console.log(d.price)
				}
				this.editedItem.total_amount=totalAmount
				this.editedItem.total_bill=totalItem


			} catch (e) {}
		},
		async generateInvoice()
		{
			// window.location.href = `/invoice/1`
			// return 
			try {
				let { data } = await axios({
					method: "post",
					url: "/app/invoice",
					data: this.editedItem
				});
				this.text = "Data added";
				this.snackbar = true;
				if(data.status)
				{
					window.location.href = `/app/invoice/${data.status.id}`
				}
				this.close();
			} catch (e) {
				this.text = "Failed";
				this.snackbar = true;
			}
		},
		selectCustomer(item)
		{
			console.log('customer clicked')
			let data={};
			for(let d of this.dataCustomer)
			{
				if(d.id==item)
				{
					data=d;
					break;
				}
			}
			// let customer = this.dataCustomer.indexOf(item);
			this.editedItem.package=data.package_id
			this.editedItem.price=data.package.price



		},
		async initialize() {
			
			try {
				let { data } = await axios({
					method: "get",
					url: "/app/customerwitharea/"+this.$store.state.authUser.area_id
				});
				this.dataCustomer = data;
			} catch (e) {}
			try {
				let { data } = await axios({
					method: "get",
					url: "/app/area/"+this.$store.state.authUser.area_id
				});
				this.dataArea = data;
			} catch (e) {}
			
		},

		editItem(item) {
			this.edit = false;
			this.editedIndex = this.dataList.indexOf(item);
			this.editedItem.year = item.year
			this.editedItem.month = item.month
			this.editedItem.customer_id = item.customer_id
			this.editedItem.package = parseInt(item.package)
			this.editedItem.price = item.price
			this.dialog = true;
		},

		deleteItem(item) {
			this.dataIndex = this.dataList.indexOf(item);
			this.deleteTitle="Are you sure you want to delete this item?";
			this.isDelete=!this.isDelete;
		},
		invoiceItem(item)
		{

		},
		async remove()
		{
			try {
				let { data } = await axios({
					method: "delete",
					url: "/app/bill/"+this.dataList[this.dataIndex].id,
				});
				this.snackBarColor='green';
				this.text = "Successfully Removed";
				this.snackbar = true;
				this.dataList.splice(this.dataIndex,1);
				this.close();
			} catch (e) {
				this.snackBarColor='red';
				this.text = "Failed";
				this.snackbar = true;
			}
		},
		deleteSelected()
		{
			this.deleteTitle="Are you sure you want to delete selected item?";
			this.isDeleteAll=!this.isDeleteAll;
		},
		deleteAll()
		{

		},

		close() {
			this.dialog = false;
			setTimeout(() => {
				this.editedItem = Object.assign({}, this.defaultItem);
				this.editedIndex = -1;
			}, 300);
		},

		async save() {
			if (this.editedIndex > -1) {
				try {
					let { data } = await axios({
						method: "put",
						url: "/app/bill/"+this.dataList[this.editedIndex].id,
						data: this.editedItem
					});
					console.log(data);
					this.text = "Data Edited";
					this.snackBarColor="green"
					this.snackbar = true;
					Object.assign(this.dataList[this.editedIndex], this.editedItem);
					this.close();
				} catch (e) {
					this.text = "Failed";
					this.snackBarColor="red"
					this.snackbar = true;
				}
			} else {
				this.editedItem.startdate=this.editedItem.year+'-'+this.editedItem.month+'-'+this.editedItem.month
				this.editedItem.enddate=this.editedItem.year+'-'+this.editedItem.month+'-'+this.editedItem.month
				try {
					let { data } = await axios({
						method: "post",
						url: "/app/bill",
						data: this.editedItem
					});
					this.text = "Data added";
					this.snackBarColor="green"
					this.snackbar = true;
					this.dataList.unshift(data.status);
					this.close();
				} catch (e) {
					this.text = "Failed";
					this.snackBarColor="red"
					this.snackbar = true;
				}
			}
		},
		
	}
};
</script>