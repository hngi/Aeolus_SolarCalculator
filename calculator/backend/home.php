<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Solar</title>
    <!-- <link rel="icon" type="image/png" sizes="32x32" href="images/favicon.png"> -->
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.7.5/css/bulma.min.css" />
    <link rel="stylesheet prefetch" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" href="/calculator/css/kanban.css" />
</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['loggedin'])) {
        header('Location: ../index.html');
        exit();
    }
    ?>
    <div id="app">
        <nav class="navbar has-shadow">
            <div class="container">
                <div class="navbar-brand">
                    <a class="navbar-item" href="../"><img src="/calculator/images/icon1.png" alt="Solar" />Solarizr</a>
                    <div class="navbar-burger burger" data-target="navMenu">
                        <span></span><span></span><span></span>
                    </div>
                </div>
                <div class="navbar-menu" id="navMenu">
                    <div class="navbar-end">
                        <div class="navbar-item has-dropdown is-hoverable"><a class="navbar-link"><?php echo $_SESSION['name'] ?></a>
                            <div class="navbar-dropdown"><a class="navbar-item">Dashboard</a>
                                <hr class="navbar-divider" />
                                <a href="logout.php" class="navbar-item">Logout</a>
                            </div>
                        </div>
                    </div>
        </nav>
        <section class="hero is-info">
            <div class="hero-body">
                <div class="container">
                    <div class="card">
                        <div class="card-content">
                            <div class="content">
                                <div class="columns">
                                    <div class="column is-7">
                                        <div class="control is-expanded">
                                            <div class="select is-large is-fullwidth">
                                                <select v-model="appliance.name">
                                                    <option value="">Select Appliance</option>
                                                    <option v-for="app in apps" :value="app.id">{{
                              app.name
                            }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column">
                                        <div class="control is-expanded">
                                            <input class="input is-large id-fullwidth" type="number" placeholder="Number of Units" v-model="appliance.no" />
                                        </div>
                                    </div>
                                    <div class="column">
                                        <div class="control is-expanded">
                                            <input class="input is-large is-fullwidth" type="number" placeholder="Wattage" v-model="appliance.wattage" />
                                        </div>
                                    </div>
                                    <div class="column">
                                        <div class="control">
                                            <button class="button is-primary is-large" @click="addAppliance()">
                                                Add Appliance
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container"></div>
            <table class="table is-responsive" style="min-height: 400px">
                <thead>
                    <tr>
                        <th>Appliance Name</th>
                        <th>Number of Units</th>
                        <th>Power consumtion per Unit</th>
                        <th>Total Power Consumtion</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(appliance, index) in appliances" :key="index">
                        <td>{{ appName(appliance.name) }}</td>
                        <td>{{ appliance.no }}</td>
                        <td>{{ appliance.wattage }}</td>
                        <td>{{ appliance.wattage * appliance.no }}</td>
                        <td><button class="button is-danger" @click="deleteAppliance(appliance.name)">
                                Delete
                            </button></td>
                    </tr>
                    <tr>
                        <th colspan="3">Total Power Required</th>
                        <th>{{ totalPower }} Watts</th>
                    </tr>
                </tbody>
            </table>


        </section>

        <div class="columns is-mobile is-centered">
            <div class="column is-half is-narrow"></div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="main.js"></script>
</body>

</html>