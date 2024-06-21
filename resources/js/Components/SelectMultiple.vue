<template>
              
                <div class="select-menu js-select-menu" id="unique-id">
                    <input class="menu-state js-menu-state" id="unique-id-menu-state" type="checkbox">
                    <label class="select-label js-select-label" :data-default-label="defaultLabel" :data-label="defaultLabel" for="unique-id-menu-state">
                    <div class="arrow"></div>
                    </label>
                    <ul class="menu js-select-options">
                    <li class="menu-item filter">
                      <input class="js-filter-input" type="text" v-model="search" placeholder="Search">
                    </li>
                    <li v-for="(option, index) in filteredOptions" :key="index" class="js-filterable" :data-filter-criteria="option.text">
                      <label class="menu-item">
                        <input class="checkbox js-option" type="checkbox" :value="option" :checked="isSelected(option)" @change="handleOptionChange(option)">
                        <div class="choice-input"></div>
                        <span>{{ option.name }}</span>
                      </label>
                    </li>
                    </ul>
                </div>

</template>

<script>
export default {
    props: {
        options: {
        type: Array,
        required: true
        },
        defaultLabel: {
        type: String,
        default: 'Select multiple'
        },
        selected: {
            type: Array,
            default: () => []
        },
    },
    data: function () {
        return {
            search: '',
        };
    },
    mounted() {
        this.setupMenu();
        this.setupOptions();
    },
    methods: {
        setupMenu() {
            this.$el.querySelectorAll(".js-select-menu").forEach((menu) => {
                menu.addEventListener("click", function () {
                    var menuState = menu.querySelector(".js-menu-state");
                    if (menuState.checked) {
                        document.addEventListener("mouseup", function handler(e) {
                            if (!menu.contains(e.target)) {
                                menuState.checked = false;
                            }
                            document.removeEventListener("mouseup", handler);
                        });
                    }
                });
            });
        },
        setupOptions() {
            this.$el.querySelectorAll(".js-option").forEach((option) => {
                option.addEventListener("change", function () {
                    var optionMenu = option.closest(".js-select-options");
                    var checkedList = optionMenu.querySelectorAll(".js-option:checked ~ span");
                    var label = optionMenu.previousElementSibling;

                    if (!checkedList.length) {
                        label.setAttribute("data-label", label.getAttribute("data-default-label"));
                        return;
                    }

                    var text = Array.from(checkedList).map(function (span) {
                        return span.textContent;
                    }).join(", ");

                    label.setAttribute("data-label", text);
                });
            });
        },
        handleOptionChange(option) {
          this.$emit('changeOption', option);
          this.$emit('updateComponent', option);
        },
        isSelected(option) {
          return this.selected.includes(option.id);
        },
    },
    computed: {
      filteredOptions() {
            if (!this.search) {
                return this.options;
            }

            const searchLower = this.search.toLowerCase();

            return this.options.filter(option =>
                option.name.toLowerCase().includes(searchLower)
            );
      }
    }
};
</script>

<style>


.dropdown {
  position: relative;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  padding: 12px 16px;
  z-index: 1;
}

.dropdown:hover .dropdown-content {
  display: block;
}






.select-menu {
  width: 100%;
}
.menu-state,
.menu {
  display: none;
}
.select-label {
  width: 100%;
  height: 40px;
  position: relative;
  display: block;
  border: 2px solid #333;
  cursor: pointer;
}
.select-label:before {
  content: attr(data-label);
  width: 100%;
  padding: 0 40px 0 16px;
  position: absolute;
  top: 50%;
  left: 0;
  transform: translateY(-50%);
  margin-top: -1px;
  font-size: 18px;
  line-height: 20px;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
.arrow {
  width: 32px;
  height: 100%;
  position: relative;
  float: right;
  background-color: #ddd;
}
.arrow:before,
.arrow:after {
  content: "";
  position: absolute;
  width: 16px;
  height: 3px;
  background-color: #00f;
  top: 53%;
  left: 50%;
}
.arrow:before {
  margin-left: -5px;
  transform: translate(-50%, -50%) rotateZ(45deg);
}
.arrow:after {
  margin-left: 5px;
  transform: translate(-50%, -50%) rotateZ(-45deg);
}
.menu {
  width: 100%;
  border-width: 0 1px 1px;
  border-style: solid;
  border-color: #333;
}
.menu-item {
  width: 100%;
  min-height: 36px;
  padding: 8px 8px 8px 36px;
  display: block;
  position: relative;
  cursor: pointer;
  border-bottom: 1px solid #333;
}
.menu-item .choice-input {
  position: absolute;
  left: 8px;
  top: 50%;
  transform: translateY(-50%);
}
.menu-item span {
  vertical-align: middle;
}
.check-all {
  padding-left: 8px;
}
li:last-child .menu-item {
  border: none;
}
.filter {
  padding: 0;
}
.filter input {
  width: 100%;
  height: 36px;
  display: block;
  padding: 0 8px;
  font-size: 14px;
  line-height: 16px;
  border: none;
  outline: none;
}
.menu-state:checked + .select-label .arrow:before,
.menu-state:checked + .select-label .arrow:after {
  width: 24px;
  top: 50%;
  margin-left: 0;
}
.menu-state:checked ~ .menu {
  display: block;
}
.checkbox,
.radio {
  display: none;
}
.checkbox + .choice-input,
.radio + .choice-input {
  width: 20px;
  height: 20px;
  display: inline-block;
  border: 1px solid #333;
  outline: none;
  background: #fff;
  cursor: pointer;
}
.checkbox:checked + .choice-input {
  border: 1px solid #00f;
  background-color: #00f;
  box-shadow: inset 0 0 0 2px #fff;
}
.radio + .choice-input {
  border-radius: 100%;
}
.toggle-container {
  height: 24px;
  width: 44px;
}
.toggle {
  display: none;
}
.toggle + label {
  transition: .2s ease;
  display: inline-block;
  height: 24px;
  width: 44px;
  position: relative;
  border-radius: 60px;
  background: #ddd;
  box-shadow: inset 0 0 0 2px #ddd;
  cursor: pointer;
  white-space: nowrap;
}
.toggle + label:before {
  content: "";
  position: absolute;
  display: block;
  height: 24px;
  width: 24px;
  top: 0;
  left: 0;
  border-radius: 12px;
  background: #ddd;
  transition: .4s ease;
}
.toggle + label:after {
  content: "";
  position: absolute;
  display: block;
  height: 22px;
  width: 22px;
  top: 50%;
  margin-top: -11px;
  left: 1px;
  border-radius: 60px;
  background: #fff;
  box-shadow: 0 0 0 1px hsla(0, 0%, 0%, 0.1),
              0 4px 0 0 hsla(0,0%,0%,.04),
              0 4px 9px hsla(0,0%,0%,.15),
              0 3px 3px hsla(0,0%,0%,.1);
  transition: .35s ease;
}
.toggle + label span {
  height: 24px;
  line-height: 24px;
  margin-left: 44px;
  padding-left: 16px;
}
.toggle:checked + label:before {
  width: 44px;
  background: #00f;
  transition: width .4s ease !important;
}
.toggle:checked + label:after {
  left: 20px;
}
.toggle:checked + label {
  box-shadow: inset 0 0 0 25px #ddd;
  transition: box-shadow 2.5s ease;
}

</style>