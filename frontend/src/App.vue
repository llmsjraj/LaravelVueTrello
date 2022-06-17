<template>
  <div style="display: flex">
    <draggable id="main" :list="columns" group="columns" :move="checkMove">
      <div
        class="column-row"
        v-for="(column, columnindex) in columns"
        :key="column.id"
        :index="columnindex"
      >
        <div class="column-list">
          <div class="list-header">
            <h3 class="list-header-title">{{ column.name }}</h3>
            <div class="column-edit-icons">
              <i
                class="column-edit-icon"
                v-on:click="editColumnicon(column.id, column.name)"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-edit"
                >
                  <path
                    d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"
                  ></path>
                  <path
                    d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"
                  ></path>
                </svg>
              </i>
              <i
                class="column-remove-icon"
                v-on:click="removeColumnicon(column.id)"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-delete"
                >
                  <path
                    d="M21 4H8l-7 8 7 8h13a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2z"
                  ></path>
                  <line x1="18" y1="9" x2="12" y2="15"></line>
                  <line x1="12" y1="9" x2="18" y2="15"></line>
                </svg>
              </i>
            </div>
          </div>
          <div
            class="column-wrapper"
            v-if="editColumnClicked && editId == column.id"
          >
            <input
              class="edit-name-input"
              v-model="updateColumn"
              required
              placeholder="Enter list title"
              @keyup.enter="editcolumn"
            />
          </div>

          <!-- Card draggable component. -->
          <div class="list-card" :list="cards" group="cards">
            <div
              class="list-card-item"
              v-for="(card, index) in cards.filter(
                (card) => card.column_id == column.id
              )"
              :key="card.id"
              :index="index"
            >
              <div class="card-title">
                {{ card.name }}
              </div>

              <div class="card-edit-icons">
                <i
                  class="card-edit-icon"
                  @click="CardUpdateModal(card.id, card.name, card.description)"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="feather feather-edit"
                  >
                    <path
                      d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"
                    ></path>
                    <path
                      d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"
                    ></path>
                  </svg>
                </i>
                <i
                  class="card-remove-icon"
                  v-on:click="removeCardicon(card.id)"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="feather feather-delete"
                  >
                    <path
                      d="M21 4H8l-7 8 7 8h13a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2z"
                    ></path>
                    <line x1="18" y1="9" x2="12" y2="15"></line>
                    <line x1="12" y1="9" x2="18" y2="15"></line>
                  </svg>
                </i>
              </div>
              <div class="card-arrow-icons">
                <i
                  class="card-left"
                  v-on:click="arrowLeft(column.id, card.id, columnindex)"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="feather feather-arrow-left"
                  >
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                  </svg>
                </i>
                <i
                  class="card-up"
                  v-on:click="arrowUp(column.id, card.id, index)"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="feather feather-arrow-up"
                  >
                    <line x1="12" y1="19" x2="12" y2="5"></line>
                    <polyline points="5 12 12 5 19 12"></polyline>
                  </svg>
                </i>
                <i
                  class="card-right"
                  v-on:click="arrowRight(column.id, card.id, columnindex)"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="feather feather-arrow-right"
                  >
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                  </svg>
                </i>
                <i
                  class="card-down"
                  v-on:click="arrowDown(column.id, card.id, index)"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="feather feather-arrow-down"
                  >
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <polyline points="19 12 12 19 5 12"></polyline>
                  </svg>
                </i>
              </div>
            </div>
          </div>

          <div class="card-item-plus">
            <div @click="CardAddModal(column.id)" class="card-item-plus-btn">
              Add a card
            </div>
          </div>
        </div>
      </div>
    </draggable>
    <div class="column-row column-create">
      <div class="column-list">
        <div class="open-add-list" @click="createColumn">
          <h3 class="list-header">Add another list</h3>
        </div>
        <div class="column-wrapper" v-if="createColumnClicked">
          <input
            class="list-name-input"
            v-model="newColumn"
            required
            placeholder="Enter list title"
            @keyup.enter="addcolumn"
          />
        </div>
      </div>
    </div>
    <modal name="addModal" :width="400" :height="250">
      <div class="modal-header">
        <input
          class="new-card-title"
          v-model="newCardTitle"
          required
          placeholder="Enter card title"
        />
      </div>
      <div class="modal-content">
        <textarea class="new-card-description" v-model="newCardDesc">
        </textarea>
      </div>
      <div class="modal-footer">
        <button class="btn-card-add" @click="addcard(selecetedColumnId)">
          Submit
        </button>
      </div>
    </modal>

    <modal name="updateModal" :width="400" :height="250">
      <div class="modal-header">
        <input
          class="update-card-title"
          v-model="updateCardTitle"
          placeholder="Enter card title"
        />
      </div>
      <div class="modal-content">
        <textarea class="update-card-description" v-model="updateCardDesc">
        </textarea>
      </div>
      <div class="modal-footer">
        <button class="btn-card-edit" @click="editcard(cardUpdateId)">
          Submit
        </button>
      </div>
    </modal>

    <div class="db-export" @click="backup">EXPORT ON</div>
  </div>
</template>

<script>
//import draggable
import draggable from "vuedraggable";
import axios from "axios";

export default {
  name: "front",
  components: {
    //import draggable as a component
    draggable,
  },
  data() {
    return {
      // for new cards and Column
      newCard: "",
      newColumn: "",
      newCardTitle: "",
      newCardDesc: "",
      columns: [],
      cards: [],

      createColumnClicked: false,
      editColumnClicked: false,
      showModal: false,
      selecetedColumnId: 0,
      cardUpdateId: 0,
      updateCardTitle: "",
      updateCardDesc: "",
    };
  },
  created() {
    axios.get(`https://backend-laravel-web.herokuapp.com/api/columns`).then((res) => {
      this.columns = JSON.parse(res.data.columns);
    });
    axios.get(`https://backend-laravel-web.herokuapp.com/api/cards`).then((res) => {
      this.cards = JSON.parse(res.data.cards);
    });
  },

  methods: {
    checkMove: function (evt) {
      axios
        .post("https://backend-laravel-web.herokuapp.com/api/columns/orderchange", {
          firstId: evt.draggedContext.element.id,
          targetId: evt.relatedContext.element.id,
        })
        .then((res) => console.log(res));
      return evt.draggedContext.element.name !== undefined;
    },

    addcolumn: function () {
      if (this.newColumn) {
        axios
          .post("https://backend-laravel-web.herokuapp.com/api/columns", { name: this.newColumn })
          .then(
            (res) => (
              (this.columns = JSON.parse(res.data.columns)),

              (this.newColumn = "")
            )
          );
      }
    },
    editcolumn: function () {
      if (this.updateColumn) {
        axios
          .patch(`https://backend-laravel-web.herokuapp.com/api/columns/${this.editId}`, {
            name: this.updateColumn,
          })
          .then((res) => {
            this.columns = JSON.parse(res.data.columns);
          });
        this.editColumnClicked = false;
      }
    },

    createColumn() {
      this.createColumnClicked = true;
    },
    editColumnicon(id, name) {
      this.editColumnClicked = true;
      this.updateColumn = name;
      this.editId = id;
    },

    removeColumnicon(id) {
      axios.delete(`https://backend-laravel-web.herokuapp.com/api/columns/${id}`).then((res) => {
        console.log(res.data);
        let i = this.columns.map((data) => data.id).indexOf(id);
        this.columns.splice(i, 1);
      });
    },
    
    // CARD
    addcard: function (id) {
      if (this.newCardTitle && this.newCardDesc) {
        axios
          .post("https://backend-laravel-web.herokuapp.com/api/cards", {
            name: this.newCardTitle,
            description: this.newCardDesc,
            column_id: id,
          })
          .then(
            (res) => (

              this.cards = JSON.parse(res.data.cards),
             console.log(this.columns[0].id, this.cards[1].column_id, this.columns[0].id == this.cards[1].column_id),
              (this.newCardTitle = ""),
              (this.newCardDesc = "")
            )
          )
          .catch((err) => console.log(err))
          .finally(() => (this.loading = false));
      }
    },
    removeCardicon(id) {
      axios.delete(`https://backend-laravel-web.herokuapp.com/api/cards/${id}`).then((res) => {
        console.log(res.data);
        let i = this.cards.map((data) => data.id).indexOf(id);
        this.cards.splice(i, 1);
      });
    },
    editcard: function (id) {
      if (this.updateCardTitle) {
        axios
          .patch(`https://backend-laravel-web.herokuapp.com/api/cards/${id}`, {
            name: this.updateCardTitle,
            description: this.updateCardDesc,
          })
          .then((res) => {
            this.cards = JSON.parse(res.data.cards);
            this.updateCardTitle = '';
            this.updateCardDesc = '';
          });
        this.$modal.hide("updateModal");
      }
    },

    CardAddModal(id) {
      this.$modal.show("addModal");
      this.selecetedColumnId = id;
    },
    CardUpdateModal(id, name, description) {
      this.$modal.show("updateModal");
      this.cardUpdateId = id;
      this.updateCardTitle = name;
      this.updateCardDesc = description;
    },

    // Arrow
    arrowUp: function (column, card, cardindex) {
      if (cardindex != 0) {
        axios
          .post("https://backend-laravel-web.herokuapp.com/api/cards/arrow", {
            column: column,
            card: card,
            cardindex: cardindex,
            arrow: "up",
          })
          .then(
            (res) => (
              console.log(res),
              (this.columns = JSON.parse(res.data.columns)),
              (this.cards = JSON.parse(res.data.cards))
            )
          )
          .catch((err) => console.log(err));
      }
    },

    arrowDown: function (column, card, cardindex) {
      var cardlingth = this.cards.filter(
        (card) => card.column_id === column
      ).length;

      if (cardindex != cardlingth - 1) {
        axios
          .post("https://backend-laravel-web.herokuapp.com/api/cards/arrow", {
            column: column,
            card: card,
            cardindex: cardindex,
            arrow: "down",
          })
          .then(
            (res) => (
              console.log(res),
              (this.columns = JSON.parse(res.data.columns)),
              (this.cards = JSON.parse(res.data.cards))
            )
          )
          .catch((err) => console.log(err));
      }
    },

    arrowLeft: function (column, card, columnindex) {
      if (columnindex != 0) {
        axios
          .post("https://backend-laravel-web.herokuapp.com/api/cards/arrow", {
            column: column,
            card: card,
            columnindex: columnindex,
            arrow: "left",
          })
          .then(
            (res) => (
              console.log(res),
              (this.columns = JSON.parse(res.data.columns)),
              (this.cards = JSON.parse(res.data.cards))
            )
          )
          .catch((err) => console.log(err));
      }
    },

    arrowRight: function (column, card, columnindex) {
      if (columnindex != this.columns.length - 1) {
        axios
          .post("https://backend-laravel-web.herokuapp.com/api/cards/arrow", {
            column: column,
            card: card,
            columnindex: columnindex,
            arrow: "right",
          })
          .then(
            (res) => (
              console.log(res),
              (this.columns = JSON.parse(res.data.columns)),
              (this.cards = JSON.parse(res.data.cards))
            )
          )
          .catch((err) => console.log(err));
      }
    },

    // Database
    backup: function () {
      axios.post(`https://backend-laravel-web.herokuapp.com/api/backup`).then((res) => {
        console.log(res.data);
        window.location.href = "https://backend-laravel-web.herokuapp.com/" + res.data.file;
      });
    },
  },
};
</script>

<style>
body {
  background: url("./assets/background.jpg");
  background-position: 50%;
  background-size: cover;
}

#main {
  bottom: 0;
  left: 0;
  margin-bottom: 8px;
  overflow-x: auto;
  overflow-y: hidden;
  padding-bottom: 8px;
  right: 0;
  top: 50px;
  -webkit-user-select: none;
  width: fit-content;
  min-width: fit-content;
  user-select: none;
  white-space: nowrap;
}

.column-row {
  box-sizing: border-box;
  display: inline-block;
  height: 100%;
  margin: 0 4px;
  vertical-align: top;
  white-space: nowrap;
  width: 272px;
  margin-left: 12px;
}

.column-list {
  background-color: #ebecf0;
  border-radius: 3px;
  box-sizing: border-box;
  display: flex;
  flex-direction: column;
  max-height: 100%;
  position: relative;
  white-space: normal;
  width: 100% !important;
}

.list-header {
  flex: 0 0 auto;
  min-height: 20px;
  padding: 10px 8px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  white-space: nowrap;
}

.list-card {
  flex: 1 1 auto;
  margin: 0 4px;
  min-height: 0;
  overflow-x: hidden;
  overflow-y: auto;
  padding: 0 4px;
  z-index: 1;
}

.list-card-item {
  background-color: #fff;
  border-radius: 3px;
  box-shadow: 0 1px 0 #091e4240;
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  margin-bottom: 8px;
  max-width: 300px;
  min-height: 30px;
  position: relative;
  text-decoration: none;
  z-index: 0;
  align-items: center;
}
.card-title {
  width: 180px;
  overflow: hidden;
  height: auto;
}

.card-item-plus-btn {
  border-radius: 3px;
  color: #5e6c84;
  display: block;
  flex: 1 0 auto;
  margin: 2px 8px 8px 8px;
  padding: 4px 8px;
  position: relative;
  text-decoration: none;
  -webkit-user-select: none;
  user-select: none;
  cursor: pointer;
}

.card-item-plus-btn:hover {
  background-color: #091e4214;
  color: #172b4d;
}

.open-add-list {
  color: #172b4d;
  background-color: initial;
  cursor: pointer;
}

.column-edit-icon {
  cursor: pointer;
}

.column-remove-icon {
  cursor: pointer;
  margin-left: 10px;
}

.column-wrapper {
  margin: 0 10px 5px 10px;
}

.column-wrapper > input {
  display: block;
  width: 100%;

  -webkit-appearance: none;
  background-color: #fafbfc;
  border: none;
  border-radius: 3px;
  box-shadow: inset 0 0 0 2px #dfe1e6;
  box-sizing: border-box;
  line-height: 20px;
  margin-bottom: 12px;
  outline: none;
  padding: 8px 12px;
  transition-duration: 85ms;
  transition-timing-function: ease;
  color: #172b4d;
  font-size: 14px;
  font-weight: 400;
}

/*---- Modal ---- */
.modal-header {
  display: flex;
  margin-top: 20px;
}

.modal-content {
  display: flex;
}

.new-card-title,
.update-card-title {
  display: block;
  width: 100%;
  padding: 0.438rem 1rem;
  margin: 10px;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.45;
  color: #6e6b7b;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #d8d6de;
  border-radius: 0.357rem;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.new-card-description,
.update-card-description {
  margin: 10px;
  padding: 0.8rem 1rem !important;
  height: auto;
  display: block;
  width: 100%;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.45;
  color: #6e6b7b;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #d8d6de;
  border-radius: 0.357rem;
}

.modal-footer {
  display: flex;
  justify-content: center;
}

.btn-card-add,
.btn-card-edit {
  display: inline-block;
  font-weight: 400;
  color: #6e6b7b;
  text-align: center;
  vertical-align: middle;
  user-select: none;
  background-color: #172b4d;
  border: 1px solid transparent;
  padding: 0.6rem 1.2rem;
  font-size: 1rem;
  line-height: 1;
  border-radius: 0.358rem;
  cursor: pointer;
}

.card-remove-icon {
  margin-top: 3px;
}

.card-edit-icons {
  display: flex;
  flex-flow: column;
}

.db-export {
  width: 100px;
  height: 80px;
  border-radius: 50%;
  border: solid 3px rgb(90, 44, 44);
  color: rgb(90, 44, 44);
  position: fixed;
  right: 50px;
  bottom: 50px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
}

/* Arrow */
.card-arrow-icons {
  display: grid;
  grid-template-columns: repeat(3, 20px);
  grid-template-rows: repeat(3, 20px);
}
.card-left {
  grid-column-start: 1;
  grid-column-end: 2;
  grid-row-start: 2;
  grid-row-end: 3;
}
.card-up {
  grid-column-start: 2;
  grid-column-end: 3;
  grid-row-start: 1;
  grid-row-end: 2;
}
.card-right {
  grid-column-start: 3;
  grid-column-end: 4;
  grid-row-start: 2;
  grid-row-end: 3;
}
.card-down {
  grid-column-start: 2;
  grid-column-end: 3;
  grid-row-start: 3;
  grid-row-end: 4;
}
</style>
