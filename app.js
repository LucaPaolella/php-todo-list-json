const { createApp } = Vue;

var app = new Vue({
    el: '#app',
    data: {
        tasks: [],
        newTask: ''
    },
    created: function () {
        this.fetchTasks();
    },
    methods: {
        fetchTasks: function () {
            var vm = this;
            axios.get('server.php')
                .then(function (response) {
                    vm.tasks = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        addTask: function () {
            var vm = this;
            var task = {
                text: vm.newTask,
                done: false
            };
            axios.post('server.php', task)
                .then(function (response) {
                    vm.tasks.push(response.data);
                    vm.newTask = '';
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        updateTask: function (index) {
            var vm = this;
            var task = vm.tasks[index];
            axios.put('server.php?id=' + task.id, task)
                .then(function (response) {

                })
                .catch(function (error) {

                });
        },
        deleteTask: function (index) {
            var vm = this;
            var task = vm.tasks[index];
            axios.delete('server.php?id=' + task.id)
                .then(function (response) {
                    vm.tasks.splice(index, 1);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
});
