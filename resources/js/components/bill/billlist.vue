<template>
	<v-content>
		<v-container fluid fill-height>
			<v-layout justify-center row>
				<v-flex xs12>
					<v-card>
						<v-toolbar flat color="white">
							<v-toolbar-title>Bill List</v-toolbar-title>
							<v-divider class="mx-2" inset vertical></v-divider>
							<v-spacer></v-spacer>
							<v-btn color="error" v-show="selected[0]" @click="deleteSelected">Delete All</v-btn>
							<v-dialog v-model="dialog" max-width="500px" persistent>
								<template v-slot:activator="{ on }">
									<v-btn color="primary" dark class="mb-2" v-on="on" @click="edit=true">New Bill</v-btn>
								</template>
								<v-card>
									<v-card-title>
										<span class="headline">{{ formTitle }}</span>
									</v-card-title >

									<v-card-text>
										<v-container grid-list-md>
											<v-layout wrap>
												<v-flex xs12 sm12 md12>
													<v-select
                                                        v-model="editedItem.customer_id"
                                                        item-text="name"
                                                        item-value="id"
														:rules="[v => !!v || 'Customer is required']"
                                                        :items="dataCustomer"
                                                        label="Customer"
														@change="selectCustomer"
                                                        ></v-select>
												</v-flex>
												<v-flex xs12 sm12 md12>
													<v-select
                                                        v-model="editedItem.package"
                                                        item-text="name"
                                                        item-value="id"
														:rules="[v => !!v || 'Package is required']"
                                                        :items="dataPackages"
                                                        label="Package"
                                                        ></v-select>
												</v-flex>
												<v-flex xs12 sm12 md6>
													<v-text-field
														v-model="editedItem.price"
														label="Price"
														required
													></v-text-field>
												</v-flex>
												<v-flex xs12 sm12 md6>
													<v-select
                                                        v-model="editedItem.month"
                                                        item-text="name"
                                                        item-value="id"
														:rules="[v => !!v || 'Month is required']"
                                                        :items="dataMonth"
                                                        label="Month"
                                                        ></v-select>
												</v-flex>
												<v-flex xs12 sm12 md12>
													<v-select
                                                        v-model="editedItem.year"
														:rules="[v => !!v || 'Year is required']"
                                                        :items="dataYear"
                                                        label="Year"
                                                        ></v-select>
												</v-flex>
											</v-layout>
										</v-container>
									</v-card-text>

									<v-card-actions>
                                        
										<v-spacer></v-spacer>
										<v-btn color="blue darken-1" flat @click="close">Cancel</v-btn>
										<v-btn color="blue darken-1" flat @click="save">Save</v-btn>
									</v-card-actions>
								</v-card>
							</v-dialog>
						</v-toolbar>
							<v-card-title>
								<v-layout align-start row fill-height>
									<v-flex ma-3>
									<v-select
										v-model="filterValue.customer"
										item-text="name"
										item-value="id"
										:items="dataCustomer"
										label="Customer"
										box
										></v-select>
									</v-flex>
									<v-flex ma-3>
									<v-select
										v-model="filterValue.month"
										item-text="name"
										item-value="id"
										:items="dataMonth"
										label="Month"
										box
										></v-select>
									</v-flex>
									<v-flex ma-3>
										<v-select
										v-model="filterValue.year"
										:items="dataYear"
										label="Year"
										box
										></v-select>
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
							<v-data-table
							v-model="selected"
							:headers="headers"
							:items="dataList"
							select-all
							:search="search"
							class="elevation-1">
							<template v-slot:items="props">
								<td>
									<v-checkbox
									v-model="props.selected"
									primary
									hide-details
									></v-checkbox>
								</td>
								<td>{{ props.item.id }}</td>
								<td>{{ props.item.year }}</td>
								<td>{{ props.item.month }}</td>
								<td>{{ props.item.customer.name }}</td>
								<td>{{ props.item.package_data.name }}</td>
								<td>{{ props.item.price }}</td>
								<td>
									<v-icon  class="mr-2" @click="editItem(props.item)" color="primary">
										edit
									</v-icon>
									<v-icon  @click="deleteItem(props.item)" color="error">
										delete
									</v-icon>
									<v-icon  @click="invoiceItem(props.item)" color="success">
										print
									</v-icon>
								</td>
							</template>
							<template v-slot:no-data>
								<v-btn color="primary" @click="initialize">Reset</v-btn>
							</template>
						</v-data-table>
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
        filterValue:
        {
            year:'',
            month:''
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
			{ text: "Action", value:"action"}
		],
		editedIndex: -1,
		editedItem: {
			customer_id: "",
			package: "",
			price: "",
			year: "",
			month: "",
		},
		defaultItem: {}
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
					url: "/app/bill"
				});
				this.dataList = data;
			} catch (e) {}
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
					Object.assign(this.dataList[this.editedIndex], this.editedItem);
					this.close();
				} catch (e) {
					this.text = "Failed";
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
					this.dataList.unshift(data.status);
					this.close();
				} catch (e) {
					this.text = "Failed";
					this.snackbar = true;
				}
			}
		},
		
	}
};
</script>