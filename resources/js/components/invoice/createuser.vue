<template>
	<v-content>
		<v-container fluid fill-height>
			<v-layout justify-center row>
				<v-flex xs12>
					<v-card>
						<v-toolbar flat color="white">
							<v-toolbar-title>User Invoice Generate</v-toolbar-title>
							<v-divider class="mx-2" inset vertical></v-divider>
							<v-spacer></v-spacer>
							<v-btn color="error" v-show="dataList.length" @click="generateInvoice">Generate Invoice</v-btn>
						</v-toolbar>
							<v-card-title>
								<v-layout align-start row fill-height>
									<v-flex ma-2>
                                        <v-autocomplete
                                            v-model="filterValue.customer"
                                            :items="dataCustomer"
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
                                            <v-list-tile-sub-title v-text="item.address"></v-list-tile-sub-title>
                                            </v-list-tile-content>
                                        </template>
                                        </v-autocomplete>
									</v-flex>
									<v-flex ma-2>
                                        <v-autocomplete
                                            v-model="filterValue.customer"
                                            :items="dataCustomer"
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
                                            <v-list-tile-sub-title v-text="item.contact"></v-list-tile-sub-title>
                                            </v-list-tile-content>
                                        </template>
                                        </v-autocomplete>
									</v-flex>
									<v-flex ma-2>
                                        <v-autocomplete
                                            v-model="filterValue.customer"
                                            :items="dataCustomer"
                                            item-text="contact"
                                            item-value="id"
                                            label="Customer Mobile"
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
								<v-spacer></v-spacer>
								<v-text-field
									v-model="search"
									append-icon="search"
									label="Search"
									outline
								></v-text-field>
							</v-card-title>
							<v-card-text>
								<v-layout align-center justify-center row fill-height>
      								<v-flex xs3>
		  								<span class="subheading">Total Amount: <b>{{editedItem.total_amount}}</b></span>
      								</v-flex>
      								<v-flex xs3>
		  								<span class="subheading">Total Bill: <b>{{editedItem.total_bill}}</b></span>
      								</v-flex>
								</v-layout>
								<v-data-table v-show="dataList.length" 
								:headers="headers"
								:items="dataList"
								:search="search">
								<template v-slot:items="props">
									<td>{{ props.item.id }}</td>
									<td>{{ props.item.year }}</td>
									<td>{{ props.item.month }}</td>
									<td>{{ props.item.customer.name }}</td>
									<td>{{ props.item.package_data.name }}</td>
									<td>{{ props.item.price }}</td>
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
		<zmodaldelete :trigger="isDeleteAll" :title="deleteTitle" :body="deleteBody" @request="deleteAll">
		</zmodaldelete>
		<zmodaldelete :trigger="isDelete" :title="deleteTitle" :body="deleteBody" @request="remove">
		</zmodaldelete>

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
import zmodaldelete from './../common/zmodaldelete';

export default {
	data: () => ({
        loading: false,
        filterValue:
        {
            customer:null,
        },
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
			{ text: "ID", align: "left", value: "id" },
			{ text: "Year", value: "year" },
			{ text: "Month", value: "month" },
			{
				text: "Customer",
				value: "customer_id"
			},
			{ text: "Package", value: "package" },
			{ text: "Bill Amount", value: "price" },
		],
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
	components:
	{
		zmodaldelete,
	},
	computed: {
		formTitle() {
			return this.editedIndex === -1 ? "New Item" : "Edit Item";
		}
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
				this.snackBarColor="red"
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
					url: "/app/customer"
				});
				this.dataCustomer = data;
            } catch (e) {}
            try {
				let { data } = await axios({
					method: "get",
					url: "/app/package"
				});
				this.dataPackages = data;
			} catch (e) {}
			this.filterValue.customer=parseInt(this.$route.params.id);
			this.getBill(this.filterValue.customer);
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
					this.snackbar = true;
					this.snackBarColor="green"
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
					this.snackbar = true;
					this.snackBarColor="green"
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