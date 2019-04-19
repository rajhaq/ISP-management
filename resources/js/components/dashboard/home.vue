<template>
    <v-content>
      <v-container fluid fill-height>
        <v-layout justify-center row >
          <v-flex xs4>
            <v-card
              class="mx-auto"
              color="blue-grey "
              dark
              max-width="400"
            >
              <v-card-title>
                <v-icon
                  large
                  left
                >
                  mdi-twitter
                </v-icon>
                <span class="title font-weight-light">Twitter</span>
              </v-card-title>

              <v-card-text class="headline font-weight-bold">
                "Turns out semicolon-less style is easier and safer in TS because most gotcha edge cases are type invalid as well."
              </v-card-text>

              <v-card-actions>
                <v-list-tile class="grow">
                  <v-list-tile-avatar color="grey darken-3">
                    <v-img
                      class="elevation-6"
                      src="https://avataaars.io/?avatarStyle=Transparent&topType=ShortHairShortCurly&accessoriesType=Prescription02&hairColor=Black&facialHairType=Blank&clotheType=Hoodie&clotheColor=White&eyeType=Default&eyebrowType=DefaultNatural&mouthType=Default&skinColor=Light"
                    ></v-img>
                  </v-list-tile-avatar>

                  <v-list-tile-content>
                    <v-list-tile-title>Evan You</v-list-tile-title>
                  </v-list-tile-content>

                  <v-layout
                    align-center
                    justify-end
                  >
                    <v-icon class="mr-1">mdi-heart</v-icon>
                    <span class="subheading mr-2">256</span>
                    <span class="mr-1">·</span>
                    <v-icon class="mr-1">mdi-share-variant</v-icon>
                    <span class="subheading">45</span>
                  </v-layout>
                </v-list-tile>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
    
</template>

<script>
  export default {
    data: () => ({
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
    }
  }
</script>