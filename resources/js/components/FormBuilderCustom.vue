<template>
  <div>
    <h4 class="text-dark">
      <i class="fa fa-calendar-minus-o"></i>
      Form Builder Event: {{event_name}}
    </h4>
    <hr />

    <section id="main">
      <!-- start: header -->
      <div class="row">
        <div class="header col-xs-12">
          <!-- <h3>Header</h3> -->
        </div>
      </div>
      <!-- end:header -->

      <!-- start:body -->
      <div class="row">
        <div class="left-sidebar col-lg-2">
          <!-- start: left sidebar -->
          <h5 class="text-dark">Options:</h5>
          <hr />
          <div class="sidebar-buttons">
            <button class="btn btn-outline-primary" v-on:click.prevent="createFourRadioBtn">
              <small>
                <i class="fa fa-circle-o-notch"></i> 4 Radio Buttons
              </small>
            </button>
            <button class="btn btn-outline-primary" v-on:click.prevent="createFiveRadioBtn">
              <small>
                <i class="fa fa-circle-o-notch"></i> 5 Radio Buttons
              </small>
            </button>
            <button class="btn btn-outline-primary" v-on:click.prevent="createCommentBox">
              <small>
                <i class="fa fa-list-alt"></i> Comment Box
              </small>
            </button>
            <button class="btn btn-outline-primary" v-on:click="returnDashboard">
              <small>
                <i class="fa fa-save"></i> Save Changes
              </small>
            </button>
          </div>
          <!-- end: left sidebar buttons-->
        </div>
        <!-- end:left side bar -->

        <div class="form-body col-lg-10">
          <!-- container use to have margin inside the form-body -->
          <div class="container">
            <draggable element="div" :options="{group: 'form'}" @end="updateOrder" v-model="Forms">
              <transition-group class="row d-block m-3 p-3">
                <div v-for="(form, index) in Forms" :key="form.id+','+form.order" :id="form.id">
                  <div class="small-card form-group-10 transition-1">
                    <span
                      class="delete-form fa fa-times close"
                      @click="deleteForm(form.id, index, form.order, form.input_type)"
                    ></span>
                    <input
                      v-if="form === editingForm"
                      @keyup.enter="endeditingForm(form)"
                      @blur="endeditingForm(form)"
                      type="text"
                      class="form-control label-input"
                      v-model="form.question"
                    />
                    <label
                      v-if="form !== editingForm"
                      @dblclick="editForm(form)"
                      :for="form.question"
                    >{{form.question}}</label>
                    <div v-if="form.input_type == 'radio'">
                      <div v-for="(option) in form.options" :key="option.id">
                        <input type="radio" :name="form.question" value="option.value" />
                        <input
                          v-if="option === editingOption"
                          @keyup.enter="endeditingOption(option)"
                          @blur="endeditingOption(option)"
                          v-model="option.label"
                          class="form-control-sm"
                          type="text"
                        />

                        <label
                          v-if="option !== editingOption"
                          @dblclick="editOption(option)"
                          class="form-control-sm"
                          :for="option.label"
                        >{{option.label}}</label>
                      </div>
                    </div>
                    <textarea
                      v-else
                      name
                      id
                      cols="10"
                      rows="5"
                      class="form-control"
                      placeholder="Comments and Recommendation (optional)"
                    ></textarea>
                  </div>
                </div>
              </transition-group>
            </draggable>
          </div>
        </div>
      </div>
      <!-- end: body -->

      <!-- start: footer -->
      <div class="row">
        <div class="footer col-xs-12">
          <!-- <h3>footer</h3> -->
        </div>
      </div>
      <!-- end: footer -->
    </section>
  </div>
</template>

<script>
import draggable from "vuedraggable";
export default {
  // data pass inside to these component to use:
  props: ["event_id", "event_name"],
  // utilities:
  components: {
    draggable
  },
  // data on these component:
  data() {
    return {
      Forms: [],
      dragging: false,
      editingForm: null,
      editingOption: null
    };
  },
  mounted() {
    console.log("Component Mounted", this.event_id);
    let hostname = window.location.origin;
    let event_id = this.event_id;
    let event_name = this.event_name;

    axios
      .get(`${hostname}/admin/forms/${event_id}`)
      .then(response => {
        console.log(response);
        let forms = response.data.response;
        forms.forEach(data => {
          if (data.input_type == "comment") {
            this.Forms.push({
              id: data.id,
              event_id: data.event_id,
              order: data.order,
              input_type: data.input_type,
              question: data.question
            });
          } else {
            this.Forms.push({
              id: data.id,
              event_id: data.event_id,
              order: data.order,
              input_type: data.input_type,
              question: data.question,
              options: []
            });
          }
        });
        console.log("Forms: ", this.Forms);
        this.loadOptions();
      })
      .catch(error => {
        console.log(error);
      });
  },
  methods: {
    // get the max order to the Forms Array
    getMaxOrder: function() {
      let forms = this.Forms;

      let getOrders = forms.map(form => {
        return form.order;
      });
      let maxOrder = Math.max.apply(Math, getOrders);

      return maxOrder;
    },
    // load all the forms
    loadForms: function() {
      this.Forms = [];
      let event_id = this.event_id;
      let hostname = window.location.origin;
      axios
        .get(`${hostname}/admin/forms/${event_id}`)
        .then(response => {
          console.log(response);
          response.data.response.forEach(data => {
            if (data.input_type == "comment") {
              this.Forms.push({
                id: data.id,
                event_id: data.event_id,
                order: data.order,
                input_type: data.input_type,
                question: data.question
              });
            } else {
              this.Forms.push({
                id: data.id,
                event_id: data.event_id,
                order: data.order,
                input_type: data.input_type,
                question: data.question,
                options: []
              });
            }
          });
          console.log("Forms: ", this.Forms);
          this.loadOptions();
        })
        .catch(error => {
          console.log(error);
        });
    },
    // load the respective options of the Forms
    loadOptions: function() {
      let hostname = window.location.origin;
      this.Forms.map(form => {
        axios
          .get(`${hostname}/admin/forms/${form.id}/option`)
          .then(response => {
            console.log("loadOption: ", response);
            form.options = response.data.response;
            console.log(this.Forms);
          })
          .catch(error => {
            console.log(error);
          });
      });
    },
    createCommentBox: function(event) {
      console.log("Comment Box", event);
      // get the event id:
      let event_id = this.event_id;
      // get the href origin:
      let hostname = window.location.origin;
      // get the max order on the forms:
      let maxOrder = this.getMaxOrder();

      let input_type = "comment";
      let question = "Comment";
      let order = (maxOrder + 1) | 0;

      axios
        .post(`${hostname}/admin/forms`, {
          event_id,
          input_type,
          question,
          order
        })
        .then(response => {
          console.log(response);
          setTimeout(() => {
            this.Forms.push({
              id: response.data.response.id,
              event_id: response.data.response.event_id,
              order: response.data.response.order,
              input_type: response.data.response.input_type,
              question: response.data.response.question
            });
          }, 1000);
        })
        .catch(error => {
          console.log(error);
        });
    },
    createFourRadioBtn: function(event) {
      console.log("Four Radio", event);
      let hostname = window.location.origin;

      let event_id = this.event_id;
      let input_type = "radio";
      let question = "Question";

      let getMax = this.getMaxOrder();
      let order = (getMax + 1) | 0;
      console.log("order", order);

      axios
        .post(`${hostname}/admin/forms`, {
          event_id,
          input_type,
          question,
          order
        })
        .then(response => {
          console.log(response);
          let form_id = response.data.response.id;
          let options = [
            {
              label: "excellent",
              value: 4
            },
            {
              label: "very satisfactory",
              value: 3
            },
            {
              label: "fair",
              value: 2
            },
            {
              label: "poor",
              value: 1
            }
          ];

          console.log("options: ", options);
          options.forEach((option, index) => {
            let label = option.label;
            let value = option.value;
            axios
              .post(`${hostname}/admin/options`, {
                form_id,
                label,
                value
              })
              .then(response => {
                console.log(response);
              })
              .catch(error => {
                console.log(error);
              });
          });
          setTimeout(() => {
            this.Forms.push({
              options: options,
              id: response.data.response.id,
              event_id: response.data.response.event_id,
              order: response.data.response.order,
              input_type: response.data.response.input_type,
              question: response.data.response.question
            });
          }, 1000);
        })
        .catch(error => {
          console.log(error);
        });
    },
    createFiveRadioBtn: function(event) {
      console.log("Five Radio", event);
      let hostname = window.location.origin;

      let event_id = this.event_id;
      let input_type = "radio";
      let question = "Question";

      let getMax = this.getMaxOrder();
      let order = (getMax + 1) | 0;
      console.log("order: ", order);

      axios
        .post(`${hostname}/admin/forms`, {
          event_id,
          input_type,
          question,
          order
        })
        .then(response => {
          console.log(response);
          let form_id = response.data.response.id;
          let options = [
            {
              id: 1,
              label: "excellent",
              value: 5
            },
            {
              id: 2,
              label: "very satisfactory",
              value: 4
            },
            {
              id: 3,
              label: "satisfactory",
              value: 3
            },
            {
              id: 4,
              label: "fair",
              value: 2
            },
            {
              id: 5,
              label: "poor",
              value: 1
            }
          ];

          console.log("options: ", options);
          options.forEach((option, index) => {
            let label = option.label;
            let value = option.value;

            axios
              .post(`${hostname}/admin/options`, {
                form_id,
                label,
                value
              })
              .then(response => {
                console.log(response);
              })
              .catch(error => {
                console.log(error);
              });
          });
          setTimeout(() => {
            this.Forms.push({
              id: response.data.response.id,
              event_id: response.data.response.event_id,
              order: response.data.response.order,
              input_type: response.data.response.input_type,
              question: response.data.response.question,
              options: options
            });
          }, 1000);
        })
        .catch(error => {
          console.log(error);
        });
    },
    returnDashboard: function() {
      var hostname = window.location.origin;
      var event_id = this.event_id;
      // window.location.href = `${hostname}/dashboard`;
      window.location.href = `${hostname}/admin/event/${event_id}/manage`;
    },
    editForm: function(form) {
      this.editingForm = form;
    },
    endeditingForm: function(form) {
      this.editingForm = null;

      let hostname = window.location.origin;
      //edit input
      axios
        .patch(`${hostname}/admin/forms/${form.id}`, {
          question: form.question,
          order: form.order
        })
        .then(response => {
          console.log(response);
        })
        .catch(error => {
          console.log(error);
        });
    },
    editOption: function(option) {
      this.editingOption = option;
    },
    endeditingOption: function(option) {
      this.editingOption = null;
      let hostname = window.location.origin;
      // edit input
      axios
        .patch(`${hostname}/admin/options/${option.id}`, {
          label: option.label
        })
        .then(response => {
          console.log(response);
        })
        .catch(error => {
          console.log(error);
        });
    },
    // function: delete form
    deleteForm: function(form_id, index, order, type) {
      let hostname = window.location.origin;
      let formId = form_id;
      let event_id = this.event_id;
      let deleteIndex = index;
      let deleteorder = order;

      let formsLength = this.Forms.length;

      console.log("form id: ", form_id);
      console.log("index: ", deleteIndex);

      this.Forms.splice(index, 1);

      // fix order when delete

      let forms = this.Forms;
      console.log(forms);

      let getFormsOrder = forms.map(form => {
        return form.order;
      });

      console.log(getFormsOrder);

      if (type == "radio") {
        axios
          .delete(`${hostname}/admin/options/${formId}`)
          .then(response => {
            console.log(response);
          })
          .catch(error => {
            console.log(error);
          });
      }

      axios
        .delete(`${hostname}/admin/forms/${formId}`)
        .then(response => {
          console.log(response);

          // re-ordering:
          if (deleteIndex <= formsLength) {
            console.log("mounted to if condition");

            let newOrderArray = getFormsOrder.map((value, index) => {
              if (deleteIndex > index) {
                console.log("same: ");
                console.log("index: ", index);
                console.log("value: ", value);
                forms[index].order = index;
              } else {
                console.log("change: ");
                console.log("index: ", index);
                console.log("value: ", value);
                forms[index].order = index;
              }
            });
          }

          forms.forEach(form => {
            axios
              .patch(`${hostname}/admin/forms/${form.id}`, {
                question: form.question,
                order: form.order
              })
              .then(response => {
                console.log(response);
              })
              .catch(error => {
                console.log(error);
              });
          });
        })
        .catch(error => {
          console.log(error);
        });
    },
    updateOrder: function(event) {
      console.log(event);

      let hostname = window.location.origin;
      let orderFrom = event.oldIndex;
      let orderTo = event.newIndex;

      console.log("orderFrom:", orderFrom);
      console.log("orderTo:", orderTo);

      let forms = this.Forms;
      let formsLength = forms.length;

      let getFormsOrder = forms.map(form => {
        return form.order;
      });
      console.log(getFormsOrder);

      if (orderTo <= formsLength) {
        let newOrder = getFormsOrder.map((value, index) => {
          if (orderTo > index) {
            console.log("same: ");
            console.log("index: ", index);
            console.log("value: ", value);
            forms[index].order = index;
          } else {
            console.log("change: ");
            console.log("index", index);
            console.log("value: ", value);
            forms[index].order = index;
          }
        });
      }

      forms.forEach(form => {
        axios
          .patch(`${hostname}/admin/forms/${form.id}`, {
            question: form.question,
            order: form.order
          })
          .then(response => {
            console.log(this.Forms);
            console.log("save:", response);
          })
          .catch(error => {
            console.log(error);
          });
      });
    }
  }
};
</script>

<style lang="scss" scoped>
.form-body {
  background-color: #f5f8fa;
}
.sidebar-buttons {
  display: grid;
  grid-template-columns: 1fr;
  grid-gap: 0.5em;
}
.small-card {
  padding: 1rem;
  background: #fff;
  margin-bottom: 0.5em;

  display: grid;
  grid-template-columns: 1fr;
}
.label-input {
  margin-bottom: 0.5em;
}
.delete-form {
  text-align: right;
  cursor: pointer;
}
</style>