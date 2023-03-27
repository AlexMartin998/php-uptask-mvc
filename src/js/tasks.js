(() => {
  const addTaskBtn = document.querySelector('#add-task');
  const filters = document.querySelectorAll('.filters input[type="radio"]');
  let tasksStore = [];
  let filteredTasks = [];
  let isFiltered = false;

  const showFormModal = (edit = false, task = {}) => {
    const modal = document.createElement('DIV');
    modal.classList.add('modal', 'overlay');
    let form;

    modal.innerHTML = `
      <form class='form new-task'>
        <legend>${edit ? 'Editar' : 'Agrega una nueva'} tarea</legend>
        <div class='field'>
          <label>Tarea</label>
          <input 
            type='text'
            name='task' 
            placeholder='${
              edit
                ? 'Edita el nombre de la Tarea'
                : 'Agregar tarea al Proyecto Actual'
            }'
            id='task' 
            value="${task.name ?? ''}"
            />
        </div>

        <div class='options'>
          <input type='submit' class='submit-new-task' value='${
            edit ? 'Editar' : 'Agregar'
          } Tarea' />
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

      if (
        e.target.classList.contains('close-modal') ||
        e.target.classList.contains('overlay')
      ) {
        form.classList.add('close');

        setTimeout(() => {
          modal.remove();
        }, 400);
      }

      if (e.target.classList.contains('submit-new-task')) {
        const taskInput = document.querySelector('#task');
        const taskName = taskInput.value.trim();
        if (!taskName.length)
          return showAlert(
            'El titulo es obligatorio',
            'error',
            document.querySelector('.form legend')
          );

        if (edit) {
          updateTaskStatus(task.id, taskName);

          form.classList.add('close');

          return modal.remove();
        }

        await saveTask(taskName);
      }
    });
  };

  addTaskBtn.addEventListener('click', () => {
    showFormModal();
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
  const saveTask = async taskName => {
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
          project_id: data.projectId,
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

  const showTasks = filteredTasks => {
    clearTasksStore();

    const taskArr = isFiltered ? filteredTasks : tasksStore;

    if (!taskArr.length) {
      const ulTasks = document.querySelector('.task-list');
      const noTasksText = document.createElement('LI');
      noTasksText.textContent = 'No hay tareas';
      noTasksText.classList.add('no-tasks');

      return ulTasks.appendChild(noTasksText);
    }

    let taskLi = '';
    taskArr.forEach(task => {
      taskLi += `
    <li class="task" data-task-id="${task.id}">
      <p class="double-click task-name">${task.name}</p>
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
        const taskId = e.target.closest('li').dataset.taskId;
        updateTaskStatus(taskId);
      });
    });
    const taskName = document.querySelectorAll('.task-name');
    taskName.forEach(btn => {
      btn.addEventListener('dblclick', async e => {
        const taskId = e.target.closest('li').dataset.taskId;
        const task = getTaskByID(taskId);
        showFormModal(true, task);
      });
    });

    tasksUl.addEventListener('dblclick', async e => {
      if (!e.target.classList.contains('double-click')) return;
      const taskId = e.target.closest('li').dataset.taskId;
      const isDeleteBtn = e.target.classList.contains('delete-task');

      if (isDeleteBtn) deleteTask(taskId);
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

  const getTaskByID = id => tasksStore.find(task => +task.id === +id);

  const createFormData = obj => {
    const formData = new FormData();
    Object.keys(obj).forEach(key =>
      formData.append(key, obj[key].toString().trim())
    );

    return formData;
  };

  const updateTaskStatus = async (taskId, taskName = '') => {
    const updatedTask = getTaskByID(taskId);
    if (!taskName) updatedTask.status = updatedTask.status === '1' ? '0' : '1';
    updatedTask.name = taskName || updatedTask.name;
    const body = createFormData(updatedTask);

    try {
      const url = 'http://localhost:3000/api/task/update';
      const resp = await fetch(url, {
        method: 'POST',
        body,
      });

      const data = await resp.json();
      if (data.ok) {
        // Swal.fire('Tarea actualizada!', data.message, data.type);

        tasksStore = tasksStore.map(task =>
          task.id === taskId ? updatedTask : task
        );

        if (isFiltered) {
          filteredTasks = filteredTasks.filter(task => task.id !== taskId);
          return showTasks(filteredTasks);
        }

        showTasks();
      }
    } catch (error) {
      console.log(error);
    }
  };

  const deleteTask = async taskId => {
    const { isConfirmed } = await Swal.fire({
      title: '¿Eliminar Tarea?',
      showCancelButton: true,
      confirmButtonText: 'Si',
      cancelButtonText: 'No',
    });
    if (!isConfirmed) return;

    const taskToDelete = getTaskByID(taskId);
    const body = createFormData(taskToDelete);

    try {
      const url = 'http://localhost:3000/api/task/delete';
      const resp = await fetch(url, {
        method: 'POST',
        body,
      });

      const data = await resp.json();
      if (data.ok) {
        Swal.fire('Eliminado!', data.message, data.type);

        tasksStore = tasksStore.filter(task => +task.id !== +taskId);

        if (isFiltered) {
          filteredTasks = filteredTasks.filter(task => +task.id !== +taskId);
          return showTasks(filteredTasks);
        }

        showTasks();
      }
    } catch (error) {
      console.log(error);
    }
  };

  // // filters
  const filterTask = e => {
    const radioValue = e.target.value;
    if (!radioValue.trim().length) {
      isFiltered = false;
      return showTasks();
    }

    isFiltered = true;
    filteredTasks = tasksStore.filter(task => +task.status === +radioValue);

    showTasks(filteredTasks);
  };

  filters.forEach(radio => {
    radio.addEventListener('input', filterTask);
  });
})();
