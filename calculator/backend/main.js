Vue.config.devtools = true;

new Vue({
  el: "#app",
  data: {
    appliances: [],
    appliance: { name: "", no: "", wattage: "" },
    user: { name: "", email: "", password: "", password_confirmation: "" },
    login: { email: "", password: "", error: "" },
    apps: [],
    isVisible: false,
    isVisible1: false
  },
  methods: {
    addAppliance() {
      if (
        this.appliance.name === "" ||
        this.appliance.no === "" ||
        this.appliance.wattage === ""
      ) {
        alert("Please fill all input fields");
      } else {
        axios({
          method: "post",
          url: "/calculator/backend/add-user-appliance.php",
          data: JSON.stringify(this.appliance)
        })
          .then(response => {
            if (response.data === "Saved!") {
              this.appliances.push({
                name: this.appliance.name,
                no: this.appliance.no,
                wattage: this.appliance.wattage
              });
              this.appliance.name = "";
              this.appliance.no = "";
              this.appliance.wattage = "";
            }
          })
          .catch(error => {
            console.error(error);
          });
      }
    },
    deleteAppliance(index) {
      if (confirm("Are you sure you want to delete?")) {
        axios({
          method: "get",
          url: "/calculator/backend/delete.php?index=" + index
        })
          .then(response => {
            if (response.data === "Record deleted successfully") {
              this.appliances.splice(this.appliances.indexOf(event), 1);
            }
          })
          .catch(error => {
            console.error(error);
          });
      }
    },
    appName(id) {
      return this.apps.find(app => app.id === id).name;
    }
  },
  computed: {
    totalPower: function() {
      return this.appliances
        .map(appliance => appliance.no * appliance.wattage)
        .reduce((prev, curr) => prev + curr, 0);
    }
  },
  created() {
    axios({
      method: "get",
      url: "/calculator/backend/appliances.php"
    })
      .then(response => {
        this.apps = response.data;
      })
      .catch(error => {
        console.error(error);
      });
    axios({
      method: "get",
      url: "/calculator/backend/user-appliances.php"
    })
      .then(response => {
        response.data.forEach(data => {
          this.appliances.push({
            name: data.appliance_id,
            no: data.no,
            wattage: data.wattage
          });
        });
      })
      .catch(error => {
        console.error(error);
      });
  }
});
