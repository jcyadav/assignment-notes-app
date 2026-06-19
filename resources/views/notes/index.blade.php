<!DOCTYPE html>
<html>
<head>
    <title>Assignment Notes App</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-6">

    <h1 class="text-3xl font-bold mb-6 text-center">
        Assignment Notes Dashboard
    </h1>

    <div class="bg-white p-4 rounded shadow mb-6">
      <input type="hidden" id="note_id">
        <input
            type="text"
            id="title"
            placeholder="Title"
            class="border p-2 w-full mb-3"
        >

        <textarea
            id="content"
            placeholder="Content"
            class="border p-2 w-full mb-3"
        ></textarea>

        <button
                id="submitBtn"
                onclick="saveOrUpdateNote()"
                class="bg-blue-600 text-white px-4 py-2 rounded"
            >
                Save Note
            </button>

    </div>

    <div class="bg-white p-4 rounded shadow mb-6">

        <input
            type="text"
            id="search"
            placeholder="Semantic Search"
            class="border p-2 w-full"
            onkeyup="searchNotes()"
        >

    </div>

    <div id="notes"></div>

</div>

<script>

const API = '/api/notes';

async function loadNotes()
{
    let response = await fetch(API);

    let data = await response.json();

    let html = '';

    data.data.forEach(note => {

        html += `
        <div class="bg-white p-4 rounded shadow mb-4">

            <h2 class="font-bold text-xl">
                ${note.title}
            </h2>

            <p class="mt-2">
                ${note.content}
            </p>

            <div class="mt-4">

                <button
                    onclick="generateSummary(${note.id})"
                    class="bg-green-600 text-white px-3 py-1 rounded"
                >
                    Generate Summary
                </button>
                    <button
                        onclick="editNote(${note.id})"
                        class="bg-yellow-500 text-white px-3 py-1 rounded ml-2"
                    >
                        Edit
                    </button>
                <button
                    onclick="deleteNote(${note.id})"
                    class="bg-red-600 text-white px-3 py-1 rounded ml-2"
                >
                    Delete
                </button>

            </div>

            <div id="summary-${note.id}"
                 class="mt-4 text-gray-700">
                ${note.summary ?? ''}
            </div>

        </div>
        `;
    });

    document.getElementById('notes').innerHTML = html;
}

// async function createNote()
// {
//     await fetch(API, {

//         method:'POST',

//         headers:{
//             'Content-Type':'application/json'
//         },

//         body:JSON.stringify({
//             title:
//             document.getElementById('title').value,

//             content:
//             document.getElementById('content').value
//         })
//     });

//     loadNotes();
// }

async function saveOrUpdateNote()
{
    let id =
        document.getElementById('note_id').value;

    let payload = {
        title:
            document.getElementById('title').value,
        content:
            document.getElementById('content').value
    };

    if(id)
    {
        await fetch(API + '/' + id, {

            method: 'PUT',

            headers: {
                'Content-Type':'application/json'
            },

            body: JSON.stringify(payload)
        });
    }
    else
    {
        await fetch(API, {

            method:'POST',

            headers:{
                'Content-Type':'application/json'
            },

            body: JSON.stringify(payload)
        });
    }

    resetForm();

    loadNotes();
}

function resetForm()
{
    document.getElementById('note_id').value = '';

    document.getElementById('title').value = '';

    document.getElementById('content').value = '';

    document.getElementById('submitBtn')
        .innerText = 'Save Note';
}
async function editNote(id)
{
    let response =
        await fetch(API + '/' + id);

    let result =
        await response.json();

    let note =
        result.data;

    document.getElementById('note_id').value =
        note.id;

    document.getElementById('title').value =
        note.title;

    document.getElementById('content').value =
        note.content;

    document.getElementById('submitBtn')
        .innerText = 'Update Note';

    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}
async function deleteNote(id)
{
    await fetch(API+'/'+id,{
        method:'DELETE'
    });

    loadNotes();
}

async function generateSummary(id)
{
    let response =
    await fetch(
        API+'/'+id+'/summary',
        {
            method:'POST'
        }
    );

    let data = await response.json();

    document.getElementById(
        'summary-'+id
    ).innerHTML =
    data.data.summary;
}

async function searchNotes()
{
    let query =
    document.getElementById('search').value;

    if(query.length < 2)
    {
        loadNotes();
        return;
    }

    let response =
    await fetch(
        API+'/search?query='+query
    );

    let data =
    await response.json();

    let html = '';

    data.results.forEach(item => {

        let note = item.note;

        html += `
        <div class="bg-white p-4 rounded shadow mb-4">

            <h2 class="font-bold">
                ${note.title}
            </h2>

            <p>
                ${note.content}
            </p>

            <small>
                Score:
                ${item.score}
            </small>

        </div>
        `;
    });

    document.getElementById('notes').innerHTML = html;
}

loadNotes();

</script>

</body>
</html>