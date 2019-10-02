<template>
	<v-content>
		<v-container fluid fill-height>
			<v-layout justify-center row>
				<v-flex xs12>
					<v-card>
						<v-toolbar flat color="white">
							<v-toolbar-title>Area List</v-toolbar-title>
							<v-divider class="mx-2" inset vertical></v-divider>
							<v-spacer></v-spacer>
							<v-btn color="error" v-show="selected[0]" @click="deleteSelected">Delete All</v-btn>
							<v-dialog v-model="dialog" max-width="500px" persistent>
								<template v-slot:activator="{ on }">
									<v-btn color="primary" dark class="mb-2" v-on="on" @click="edit=true">New Area</v-btn>
								</template>
								<v-card>
									<v-card-title>
										<span class="headline">{{ formTitle }}</span>
									</v-card-title >

									<v-card-text>
										<v-container grid-list-md>
											<v-layout wrap>
												<v-flex xs12 sm12 md12>
													<v-text-field
														v-model="editedItem.name"
														label=" Name"
														:rules="[v => !!v || 'Name is required']"
														required
														box
													></v-text-field>
												</v-flex>
												<v-flex xs12 sm12 md12>
													<v-text-field
														v-model="editedItem.code"
														label="Area Code(optional)"
														box
													></v-text-field>
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
								
								<v-spacer></v-spacer>
								<v-text-field
									v-model="search"
									append-icon="search"
									label="Search"
									single-line
									hide-details
									outline
								></v-text-field>
							</v-card-title>
							<v-data-table
							:pagination.sync="pagination"
							:headers="headers"
							:items="dataList"
							:search="search"
							class="elevation-1">
							<template v-slot:items="props">
								<td>{{ props.item.id }}</td>
								<td>{{ props.item.name }}</td>
								<td>{{ props.item.code }}</td>
								<td>
									<v-icon small class="mr-2" @click="editItem(props.item)" color="primary">
										edit
									</v-icon>

									<v-icon small @click="deleteItem(props.item)" color="error">
										delete
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
		pagination:{
			rowsPerPage: 25 // -1 for All",
		},
		snackBarColor:'green',
		isDelete:false,
		isDeleteAll:false,
		dataIndex:null,
		deleteTitle:'',
		deleteBody:'',
		search:'',
		selected: [],
		snackbar: false,
		y: "top",
		x: null,
		mode: "",
		text: "Hello, I'm a snackbar",
		edit: true,
		dialog: false,
		dataList: [],
		headers: [
			{ text: "ID", align: "left", value: "id" },
			{
				text: "Name",
				value: "name"
			},
			{ text: "Code", value: "code" },
			{ text: "Action", value:"action"}
		],
		editedIndex: -1,
		editedItem: {
			name: "",
			code: "",
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
	},

	methods: {
		async initialize() {
			try {
				let { data } = await axios({
					method: "get",
					url: "/app/area"
				});
				this.dataList = data;
			} catch (e) {}
		},

		editItem(item) {
			this.edit = false;
			this.editedIndex = this.dataList.indexOf(item);
			this.editedItem = Object.assign({}, item);
			this.dialog = true;
		},

		deleteItem(item) {
			this.dataIndex = this.dataList.indexOf(item);
			this.deleteTitle="Are you sure you want to delete this item?";
			this.isDelete=!this.isDelete;
		},
		async remove()
		{
			try {
				let { data } = await axios({
					method: "delete",
					url: "/app/area/"+this.dataList[this.dataIndex].id,
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
						url: "/app/area/"+this.dataList[this.editedIndex].id,
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
				try {
					let { data } = await axios({
						method: "post",
						url: "/app/area",
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