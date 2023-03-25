(() => {
  const addTaskBtn = document.querySelector('#add-task');

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

  // crud task
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

      if (data.ok)
        return setTimeout(() => {
          document.querySelector('.modal').remove();
        }, 2100);
    } catch (error) {
      console.log(error);
    }
  };

  const getProjectUrl = () => {
    const params = new URLSearchParams(window.location.search);

    return Object.fromEntries(params.entries());
  };

  const showTasks = tasks => {
    if (!tasks.length) {
      const ulTasks = document.querySelector('.task-list');
      const noTasksText = document.createElement('LI');
      noTasksText.textContent = 'No hay tareas';
      noTasksText.classList.add('no-tasks');

      return ulTasks.appendChild(noTasksText);
    }

    /*  tasks.forEach(task => {
      const taskLi = document.createElement('LI');
      taskLi.dataset.taskId = task.id;
      taskLi.classList.add('task');

      const taskName = document.createElement('P');
      taskName.textContent = task.name;

      const optionsDiv = document.createElement('DIV');
      optionsDiv.classList.add('options');

      const btnTaskStatus = document.createElement('BUTTON');
      btnTaskStatus.classList.add(
        'task-status',
        `${!+task.status ? 'pendiente' : 'completada'}`
      );
      btnTaskStatus.textContent = !+task.status ? 'Pendiente' : 'Completada';
      btnTaskStatus.dataset.taskStatus = task.status;

      const btnDeleteTask = document.createElement('BUTTON');
      btnDeleteTask.classList.add('delete-task');
      btnDeleteTask.dataset.taskId = task.id;
      btnDeleteTask.textContent = 'Eliminar';

      //
      optionsDiv.appendChild(btnTaskStatus);
      optionsDiv.appendChild(btnDeleteTask);
      taskLi.appendChild(taskName);
      taskLi.appendChild(optionsDiv);

      const tasksUl = document.querySelector('.task-list');
      tasksUl.append(taskLi);
    }); */
    tasks.forEach(task => {
      const taskLi = `
        <li class="task" data-task-id="${task.id}">
          <p>${task.name}</p>
          <div class="options">
            <button class="task-status ${
              !+task.status ? 'pending' : 'completed'
            }" data-task-status="${task.status}">
              ${!+task.status ? 'Pendiente' : 'Completada'}
            </button>
            <button class="delete-task" data-task-id="${
              task.id
            }">Eliminar</button>
          </div>
        </li>`;

      const tasksUl = document.querySelector('.task-list');
      // tasksUl.insertAdjacentHTML('beforeend', taskLi);
      tasksUl.innerHTML += taskLi;
    });
  };

  const getProjectTasks = async () => {
    try {
      const url = `/api/tasks?id=${getProjectUrl().id}`;
      const resp = await fetch(url);
      const tasks = await resp.json();

      showTasks(tasks);
    } catch (error) {
      console.log(error);
    }
  };
  getProjectTasks();
})();
