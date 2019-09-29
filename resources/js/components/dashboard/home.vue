<template>
    <v-content>
      <v-container fluid>
        <v-layout justify-center row >
          <v-flex xs4>
            <v-card
              class="ma-3"
              color="blue-grey "
              dark
            >
              <v-card-title>
                <v-icon
                  large
                  left
                >
                  mdi-account
                </v-icon>
                <span class="title font-weight-light">Total Customer</span>
              </v-card-title>

              <v-card-text class="display-4 font-weight-bold">
                {{dashboard.customer}}
              </v-card-text>

            </v-card>
          </v-flex>

          <v-flex xs4>
            <v-card
              class="ma-3"
              color="blue-grey "
              dark
            >
              <v-card-title>
                <v-icon
                  large
                  left
                >
                mdi-calendar
                </v-icon>
                <span class="title font-weight-light">This Month Bill</span>
              </v-card-title>

              <v-card-text class="display-4 font-weight-bold">
                {{dashboard.bill}}
              </v-card-text>

            </v-card>
          </v-flex>
          <v-flex xs4>
            <v-card
              class="ma-3"
              color="blue-grey "
              dark
            >
              <v-card-title>
                <v-icon
                  large
                  left
                >
                  mdi-checkbox-marked
                </v-icon>
                <span class="title font-weight-light">Collected Bill</span>
              </v-card-title>

              <v-card-text class="display-4 font-weight-bold">
                {{dashboard.pending_bill}}
              </v-card-text>

            </v-card>
          </v-flex>
 
        </v-layout>
        <v-layout justify-center align-center v-show="!dashboard.create">
          <v-flex>
            <h3> There is no bill for this month</h3>
            <div>
              <v-btn large color="primary" @click="generatebill">Generate Bill</v-btn>
            </div>
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
    snackBarColor:'green',
    snackbar: false,
		y: "top",
		x: null,
		mode: "",
		text: "Hello, I'm a snackbar",
		edit: true,
		dialog: false,
        dataList: [],
      dashboard:
      {
        customer:'',
        bill:'',
        pending_bill:''
      },
      labels: [
        '12am',
        '3am',
        '6am',
        '9am',
        '12pm',
        '3pm',
        '6pm',
        '9pm'
      ],
      value: [
        200,
        675,
        410,
        390,
        310,
        460,
        250,
        240
      ],
      dialog: false,
      drawer: null,
      items: [
        { icon: 'contacts', text: 'Customer Contacts' },
        { icon: 'history', text: 'Frequently contacted' },
        { icon: 'content_copy', text: 'Duplicates' },
        {
          icon: 'keyboard_arrow_up',
          'icon-alt': 'keyboard_arrow_down',
          text: 'Labels',
          model: true,
          children: [
            { icon: 'add', text: 'Create label' }
          ]
        },
        {
          icon: 'keyboard_arrow_up',
          'icon-alt': 'keyboard_arrow_down',
          text: 'More',
          model: false,
          children: [
            { text: 'Import' },
            { text: 'Export' },
            { text: 'Print' },
            { text: 'Undo changes' },
            { text: 'Other contacts' }
          ]
        },
        { icon: 'settings', text: 'Settings' },
        { icon: 'chat_bubble', text: 'Send feedback' },
        { icon: 'help', text: 'Help' },
        { icon: 'phonelink', text: 'App downloads' },
        { icon: 'keyboard', text: 'Go to the old version' }
      ]
    }),
    props: {
      source: String
    },
    created(){
      this.initialize();
    },
    methods:{
      
      async generatebill() {
      
      try {
        let { data } = await axios({
          method: "get",
          url: "/app/billgenerate"
        });
        this.snackBarColor='green';
				this.text = "Successfully Removed";
				this.snackbar = true;
        this.dashboard.create = data;
            } catch (e) {}

    },
      async initialize() {
      
      try {
        let { data } = await axios({
          method: "get",
          url: "/app/dashboard"
        });
        this.dashboard = data;
            } catch (e) {}

    },
    }
  }
</script>