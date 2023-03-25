(() => {
  const addTaskBtn = document.querySelector('#add-task');

  addTaskBtn.addEventListener('click', e => {
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
    modal.addEventListener('click', e => {
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

        console.log('first');
      }
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

    //
    const addNewTask = async () => {
      //
    };
  });
})();
