<template>
	<v-content>
		<v-container fluid fill-height>
			<v-layout justify-center row>
				<v-flex xs12>
					<v-card>
						<v-toolbar flat color="white">
							<v-toolbar-title>User List</v-toolbar-title>
							<v-divider class="mx-2" inset vertical></v-divider>
							<v-spacer></v-spacer>
							<v-dialog v-model="dialog" max-width="500px" persistent>
								<template v-slot:activator="{ on }">
									<v-btn color="primary" dark class="mb-2" v-on="on" @click="edit=true">New User</v-btn>
								</template>
								<v-card>
									<v-card-title>
										<span class="headline">{{ formTitle }}</span>
									</v-card-title>

									<v-card-text>
										<v-container grid-list-md>
											<v-layout wrap>
												<v-flex xs12 sm12 md12>
													<v-text-field
														v-model="editedItem.name"
														label="Full Name"
														:rules="[v => !!v || 'User type is required']"
														required
														box
													></v-text-field>
												</v-flex>

												<v-flex xs12 sm12 md12>
													<v-text-field :rules="emailRules" v-model="editedItem.email" label="Email"
													box></v-text-field>
												</v-flex>
												<v-flex xs12 sm12s md12 v-if="edit">
													<v-text-field
														v-model="editedItem.password"
														:rules="passwordRules"
														label="Password"
														type="password"
														box
													></v-text-field>
												</v-flex>
												<v-flex xs12 sm12 md12>
													<v-select
														v-model="editedItem.userType"
														:items="userType"
														:rules="[v => !!v || 'User type is required']"
														label="User Type"
														required
														box
													></v-select>
												</v-flex>
												<v-flex xs12 sm12 md12 v-show="editedItem.userType=='Collector'">
													<v-select
														v-model="editedItem.area_id"
														:items="dataArea"
														item-text="name"
														item-value="id"
														label="Area"
														box
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
							:items="dataUser"
							:search="search"
							class="elevation-1">
							<template v-slot:items="props">
								<td>{{ props.item.id }}</td>
								<td>{{ props.item.name }}</td>
								<td>{{ props.item.email }}</td>
								<td>{{ props.item.userType }}</td>
								<td class="justify-center layout px-0">
									<v-icon small class="mr-2" @click="editItem(props.item)" color="primary">edit</v-icon>
									<v-icon small class="mr-2" @click="deleteItem(props.item)" >
										delete
									</v-icon>
									<v-icon small @click="setPass(props.item)" >
										lock
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
		<v-snackbar
			v-model="snackbar"
			:bottom="y === 'bottom'"
			:left="x === 'left'"
			:multi-line="mode === 'multi-line'"
			:right="x === 'right'"
			:timeout="timeout"
			:top="y === 'top'"
			:vertical="mode === 'vertical'"
		>
			{{ text }}
			<v-btn color="pink" flat @click="snackbar = false">Close</v-btn>
		</v-snackbar>
			<zmodaldelete :trigger="isDelete" :title="deleteTitle" :body="deleteBody" @request="remove">
			</zmodaldelete>	
	</v-content>
</template>

<script>
import zmodaldelete from './../common/zmodaldelete';
export default {
	data: () => ({
		isDelete:false,
		deleteBody:'',
		deleteTitle:'',
		dataIndex:null,
		pagination:{
			rowsPerPage: 25 // -1 for All",
		},
		search:'',
		selected: [],
		snackbar: false,
		y: "top",
		x: null,
		mode: "",
		timeout: 6000,
		text: "Hello, I'm a snackbar",
		edit: true,
		dialog: false,
		dataUser: [],
		dataArea:[],
		userType: ["Admin", "Manager", "Collector"],

		headers: [
			{ text: "ID", align: "left", value: "id" },
			{
				text: "Name",
				value: "name"
			},
			{ text: "Email", value: "email" },
			{ text: "Type", value: "type" },
			{ text: "Action"}
		],
		emailRules: [
			v => !!v || "E-mail is required",
			v => /.+@.+/.test(v) || "E-mail must be valid"
		],
		usernameRules: [
			v => !!v || "Name is required",
			v => (v || "").indexOf(" ") < 0 || "No spaces are allowed"
		],
		passwordRules: [
			v => (v || "").length >= 8 || `A minimum of 8 characters is allowed`
		],

		editedIndex: -1,
		editedItem: {
			name: "",
			email: "",
			userType: "",
			area_id:""
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
					url: "/api/users"
				});
				this.dataUser = data;
			} catch (e) {}
			try {
				let { data } = await axios({
					method: "get",
					url: "/app/area"
				});
				this.dataArea = data;
			} catch (e) {}
		},

		editItem(item) {
			this.edit = false;
			this.editedIndex = this.dataUser.indexOf(item);
			this.editedItem = Object.assign({}, item);
			this.dialog = true;
		},
		setPass(item) {
			this.edit = false;
			this.editedIndex = this.dataUser.indexOf(item);
			this.editedItem = Object.assign({}, item);
			this.dialog = true;
		},

		deleteItem(item) {
			this.dataIndex = this.dataUser.indexOf(item);
			this.deleteTitle="Are you sure you want to delete this item?";
			this.isDelete=!this.isDelete;
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
						method: "post",
						url: "/app/updateUser",
						data: this.editedItem
					});
					console.log(data);
					this.text = "User Edited";
					this.snackbar = true;
					Object.assign(this.dataUser[this.editedIndex], this.editedItem);
					this.close();
				} catch (e) {
					this.text = "Failed";
					this.snackBarColor="red"
					this.snackbar = true;
				}
			} else {
				try {
					let { data } = await axios({
						method: "post",
						url: "/api/users",
						data: this.editedItem
					});
					this.text = "New User Added";
					this.snackbar = true;
					this.dataUser.unshift(this.editedItem);
					this.close();
				} catch (e) {
					this.text = "Failed";
					this.snackBarColor="red"
					this.snackbar = true;
				}
			}
		},
		async remove()
		{
			try {
				let { data } = await axios({
					method: "delete",
					url: "/api/users/"+this.dataUser[this.dataIndex].id,
				});
				this.snackBarColor='green';
				this.text = "Successfully Removed";
				this.snackbar = true;
				this.dataUser.splice(this.dataIndex,1);
				this.close();
			} catch (e) {
				this.snackBarColor='red';
				this.text = "Failed, try again";
				this.snackbar = true;
			}
		},
		async setPass(item)
		{
			try {
				let { data } = await axios({
					method: "get",
					url: "/app/updatepassword/"+item.id,
				});
				this.snackBarColor='green';
				this.text = "Successfully Changed, new password is 'password'";
				this.snackbar = true;
			} catch (e) {
				this.snackBarColor='red';
				this.text = "Failed, try again";
				this.snackbar = true;
			}
		},
		toggleAll () {
        if (this.selected.length) this.selected = []
        else this.selected = this.desserts.slice()
      },
      changeSort (column) {
        if (this.pagination.sortBy === column) {
          this.pagination.descending = !this.pagination.descending
        } else {
          this.pagination.sortBy = column
          this.pagination.descending = false
        }
      }
	}
};
</script>