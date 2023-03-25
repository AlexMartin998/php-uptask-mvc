(() => {
  const addTaskBtn = document.querySelector('#add-task');
  let tasksStore = [];

  addTaskBtn.addEventListener('click', () => {
    const modal = document.createElement('DIV');
    modal.classList.add('modal');
    let form;

    modal.innerHTML = `
      <form class='form new-task'>
        <legend>Agrega una nueva tarea</legend>
        <div class='field'>
          <label>Tarea</label>
          <input type='text' name='task' placeholder='Agregar tarea al Proyecto Actual' id='task' />
        </div>

        <div class='options'>
          <input type='submit' class='submit-new-task' value='Agregar Tarea' />
          <button type='button' class='close-modal'>Cancelar</button>
        </div>
      </form>
    `;

    setTimeout(() => {
      form = document.querySelector('.form');
      form.classList.add('animate');
    }, 0);

    document.querySelector('.dashboard').appendChild(modal);

    // handle modal
    modal.addEventListener('click', async e => {
      e.preventDefault();

      if (e.target.classList.contains('close-modal')) {
        form.classList.add('close');

        setTimeout(() => {
          modal.remove();
        }, 400);
      }

      if (e.target.classList.contains('submit-new-task')) {
        const taskInput = document.querySelector('#task');
        if (!taskInput.value.trim().length)
          return showAlert(
            'El titulo es obligatorio',
            'error',
            document.querySelector('.form legend')
          );

        await addNewTask(taskInput.value.trim());
      }
    });
  });

  const showAlert = (message, type, ref) => {
    const prevAlert = document.querySelector('.alert');
    prevAlert && prevAlert.remove();

    const alerta = document.createElement('DIV');
    alerta.classList.add('alert', type);
    alerta.textContent = message;

    ref.parentElement.insertBefore(alerta, ref.nextElementSibling);

    setTimeout(() => {
      alerta.remove();
    }, 2000);
  };

  // // crud task
  const addNewTask = async taskName => {
    const projectIdUrl = getProjectUrl();

    // form for mvc
    const body = new FormData();
    body.append('name', taskName);
    body.append('project_id', projectIdUrl.id);

    try {
      const url = 'http://localhost:3000/api/tasks';
      const resp = await fetch(url, {
        method: 'POST',
        body,
      });
      const data = await resp.json();
      showAlert(
        data.message,
        data.type,
        document.querySelector('.form legend')
      );

      if (data.ok) {
        const newTask = {
          id: data.id,
          name: taskName,
          project_id: data.projectId.toString(),
          status: 0,
        };

        tasksStore = [...tasksStore, newTask];
        showTasks(tasksStore);

        return setTimeout(() => {
          document.querySelector('.modal').remove();
        }, 1200);
      }
    } catch (error) {
      console.log(error);
    }
  };

  const getProjectUrl = () => {
    const params = new URLSearchParams(window.location.search);

    return Object.fromEntries(params.entries());
  };

  const showTasks = () => {
    clearTasksStore();

    if (!tasksStore.length) {
      const ulTasks = document.querySelector('.task-list');
      const noTasksText = document.createElement('LI');
      noTasksText.textContent = 'No hay tareas';
      noTasksText.classList.add('no-tasks');

      return ulTasks.appendChild(noTasksText);
    }

    let taskLi = '';
    tasksStore.forEach(task => {
      taskLi += `
    <li class="task" data-task-id="${task.id}">
      <p>${task.name}</p>
      <div class="options">
        <button class="task-status double-click ${
          !+task.status ? 'pending' : 'completed'
        }" data-task-status="${task.status}">
          ${!+task.status ? 'Pendiente' : 'Completada'}
        </button>
        <button class="delete-task double-click" data-task-id="${
          task.id
        }">Eliminar</button>
      </div>
    </li>`;
    });
    const tasksUl = document.querySelector('.task-list');
    tasksUl.innerHTML += taskLi;

    const statusBtns = document.querySelectorAll('.task-status');
    statusBtns.forEach(btn => {
      btn.addEventListener('dblclick', async e => {
        const taskId = e.target.parentElement.parentElement.dataset.taskId;
        updateTaskStatus(taskId);
      });
    });

    tasksUl.addEventListener('dblclick', async e => {
      if (!e.target.classList.contains('double-click')) return;
      const taskId = e.target.parentElement.parentElement.dataset.taskId;
      const isDeleteBtn = e.target.classList.contains('delete-task');
      if (isDeleteBtn) {
        deleteTask(taskId);
      }
    });
  };

  const getProjectTasks = async () => {
    try {
      const url = `/api/tasks?id=${getProjectUrl().id}`;
      const resp = await fetch(url);
      tasksStore = await resp.json();

      showTasks(tasksStore);
    } catch (error) {
      console.log(error);
    }
  };
  getProjectTasks();

  const clearTasksStore = () => {
    const taskList = document.querySelector('.task-list');

    while (taskList.firstChild) {
      taskList.removeChild(taskList.firstChild);
    }
  };

  const getTaskByID = id => {
    return tasksStore.find(task => task.id === id);
  };

  const updateTaskStatus = async taskId => {
    const updatedTask = getTaskByID(taskId);
    updatedTask.status = updatedTask.status === '1' ? '0' : '1';
    const body = new FormData();
    Object.keys(updatedTask).forEach(key =>
      body.append(key, updatedTask[key].trim())
    );

    try {
      const url = 'http://localhost:3000/api/task/update';
      const resp = await fetch(url, {
        method: 'POST',
        body,
      });

      const data = await resp.json();
      if (data.ok) {
        showAlert(
          data.message,
          data.type,
          document.querySelector('.new-task-container')
        );

        tasksStore = tasksStore.map(task =>
          task.id === taskId ? updatedTask : task
        );

        showTasks();
      }
    } catch (error) {
      console.log(error);
    }
  };

  const deleteTask = async taskId => {
    let proceed;
    Swal.fire({
      title: '¿Eliminar Tarea?',
      showCancelButton: true,
      confirmButtonText: 'Si',
      cancelButtonText: 'No',
    }).then(result => {
      if (result.isConfirmed) proceed = true;
    });
    if (!proceed) return;

    const taskToDelete = getTaskByID(taskId);
  };
})();
