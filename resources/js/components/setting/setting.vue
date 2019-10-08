<template>
	<v-content>
		<v-container fluid fill-height>
			<v-layout justify-center row>
				<v-flex xs12 md8 >
					<v-card>
							<v-card-title>
								Settings
							</v-card-title>
							<v-card-text>
								<v-layout align-center justify-center row fill-height>

                                <v-flex xs12 sm12 md12>												
									<v-img
									:src="image"
									max-width="300px" max-height="300px"
									>
									</v-img>
									<v-btn @click="$refs.inputUpload.click()" color="blue-grey" 
										class="white--text mb-3">Upload <v-icon right dark >add_a_photo</v-icon>
									</v-btn>

									<input v-show="false" ref="inputUpload" accept="image/*" type="file" @change="profileChange()" >
												
                                    <v-text-field
                                        v-model="editedValue.name"
                                        label="Company Name"
                                        box
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="editedValue.address"
                                        label="Company Address"
                                        box
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="editedValue.number"
                                        label="Phone Number"
                                        box
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="editedValue.currency"
                                        label="Currency"
                                        box
                                    ></v-text-field>
									<v-text-field
                                        v-model="editedValue.invoice_message"
                                        label="Invoice Bottom Message"
                                        box
                                    ></v-text-field>
									<v-btn color="primary" @click="update">Update</v-btn>
                                    </v-flex>
								</v-layout>
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
import zmodaldelete from './../common/zmodaldelete';

export default {
	data: () => ({
		image:'/upload.png',
        loading: false,
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
        dataSetting:[],
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
		editedValue: {
			name: "",
			address:'',
			number:'',
			currency:'',
			invoice_message:'',
			image:'',

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
	async profileChange(e)
    {
		console.log(event.target.files[0])
		this.imageFile = event.target.files[0]
		var blob = event.target.files[0];
		var URLObj = this._getURLObj();
		this.image = URLObj.createObjectURL(blob);
    },
    _getURLObj(){
       return window.URL || window.webkitURL;
     },


		async initialize() {
			
			try {
				let { data } = await axios({
					method: "get",
					url: "/app/setting"
				});
				this.editedValue = data;
				if(data.image)
				{
					this.image=data.image
				}
            } catch (e) {}

		},
		async update() {
				try {
					const formData = new FormData()
					  formData.append('myFile', this.imageFile)
					  for(var key in this.editedValue)
					  {
						  formData.append(key,this.editedValue[key])
					  }
					let { data } = await axios({
						method: "post",
						url: "/app/setting",
						data: formData
					});
					this.text = "Data Updated";
					this.snackBarColor="green"
					this.snackbar = true;
				} catch (e) {
					console.log(e)
					this.text = "Failed";
					this.snackBarColor="red"
					this.snackbar = true;
				}
			
		},
		
	}
};
</script>