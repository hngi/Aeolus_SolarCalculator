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
        const val = this.appliances.push({
          name: this.appliance.name,
          no: this.appliance.no,
          wattage: this.appliance.wattage
        });
        this.appliance.name = "";
        this.appliance.no = "";
        this.appliance.wattage = "";
      }
    },
    saveData() {
      axios({
        method: "post",
        url: "./backend/register.php",
        data: {
          name: this.user.name,
          email: this.user.email,
          password: this.user.password,
          password_confirmation: this.user.password_confirmation
        }
      })
        .then(response => {
          if (
            response.data ===
            "You have successfully registered, you can now login!!"
          ) {
            axios({
              method: "post",
              url: "./backend/login.php",
              data: { email: this.user.email, password: this.user.password }
            })
              .then(response => {
                if (response.data === "Login Successful!") {
                  axios({
                    method: "post",
                    url: "./backend/calculator.php",
                    data: JSON.stringify(this.appliances)
                  })
                    .then(response => {
                      if (response.data === "Saved!") {
                        window.location = "backend/home.php";
                      }
                    })
                    .catch(error => {
                      console.error(error);
                    });
                }
              })
              .catch(error => {
                console.error(error);
              });
          } else {
            alert(response.data);
          }
        })
        .catch(error => {
          console.error(error);
        });
      this.isVisible = false;
    },
    loginUser() {
      axios({
        method: "post",
        url: "./backend/login.php",
        data: { email: this.login.email, password: this.login.password }
      })
        .then(response => {
          if (response.status === 200) {
            window.location = "./backend/home.php";
          } else {
            this.login.error = response.data;
          }
        })
        .catch(error => {
          this.login.error = "Login Failed, email or password incorrect";
          console.error(error);
        });
    },
    deleteAppliance(index) {
      if (confirm("Are you sure you want to delete?")) {
        this.appliances.splice(index, 1);
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
      url: "./backend/appliances.php"
    })
      .then(response => {
        this.apps = response.data;
      })
      .catch(error => {
        console.error(error);
      });
  }
});
