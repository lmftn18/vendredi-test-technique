<!--suppress ALL -->
<template>
    <div>

        <!-- the input field -->

        <p v-if="selectedId" class="form-control form-control-static">
            {{displayedValue}}
            <a @click.prevent="onClose" href="#" class="pull-right bandeau-close"><img src="images/modal-close.png"
                                                                                       class="close-icon"
                                                                                       aria-hidden="true"></a>
        </p>
        <input v-else
               required
               data-minlength="300"
               data-error="Sélectionne une école"
               type="text"
               class="form-control"
               placeholder="École"
               autocomplete="off"
               v-model="query"
               @keydown.down="down"
               @keydown.up="up"
               @keydown.enter.prevent="hit"
               @keydown.esc.prevent="reset"

               @input="update"/>
        <input type="hidden" name="school" v-bind:value="selectedId"/>

        <ul class="dropdown-menu typeahead" v-show="hasItems">
            <li v-for="(item, index) in items" :class="activeClass(index)" @mousedown="hit"
                @mousemove="setActive(index)">
                <!--suppress CheckTagEmptyBody -->
                <a v-text="item.value"></a>
            </li>
        </ul>
        <div v-if="!selectedId" class="help-block with-errors"></div>
    </div>
</template>

<script>
import VueTypeahead from 'vue-typeahead';
import _ from 'lodash';
export default {
  extends: VueTypeahead,
  props : {
    defaultSelectedId : false,
    defaultSelectedValue : '',
    onChange : false,
  },
  data () {
    return {
      // The source url
      // (required)
      src: '/ajax/school',
      selectedId : this.defaultSelectedId,
      selectedValue : this.defaultSelectedValue,
      // The data that would be sent by request
      // (optional)
      data: {
      },

      // Limit the number of items which is shown at the list
      // (optional)
      limit: 5,

      // The minimum character length needed before triggering
      // (optional)
      minChars: 1,

      // Highlight the first item in the list
      // (optional)
      selectFirst: false,

      // Override the default value (`q`) of query parameter name
      // Use a falsy value for RESTful query
      // (optional)
      queryParamName: 'search'
    }
  },
  mounted : function(){
    // Will refactor this if the code gets more complex
    $("#userInscriptionForm").validator('update');
    $("#userChangeInfoForm").validator('update');
  },
  computed : {
    displayedValue : function(){
        return this.selectedValue.length > 40 ? this.selectedValue.substr(0,37) + '...' : this.selectedValue ;
    }
  },
  methods: {
    onClose () {
        this.selectedId = false;
        this.selectedValue = '';
        this.query = '';
    },
    // The callback function which is triggered when the user hits on an item
    // (required)
    onHit (item) {
        if(item){

            this.selectedId = item.id;
            this.selectedValue = item.value;
            this.query = item.value;
            this.items = [];
        }

        if(this.onChange && _.isFunction(this.onChange)){
            this.onChange();
        }
    },

    activeClass (index) {
      return {
        active: this.current === index
      }
    },

    // The callback function which is triggered when the response data are received
    // (optional)
    prepareResponseData (data) {
      // data = ...
      return data.data;
    }
  }
}






</script>
