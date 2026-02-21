const degreeSelect = document.getElementById('degree');
const majorSelect = document.getElementById('majors');
const StudyTimeSelect = document.getElementById('study_time');
const degreeIdInp = document.getElementById('degree_id');

// ទាយទិន្នន័យពី Database អក្សរតូច បំលែងទៅជា អក្សរធំនៅក្នុង View
function titleCase(text) {
    return text
        .toLowerCase()
        .replace(/\b\w/g, char => char.toUpperCase());
}


/* ✅ Change Degree */
degreeSelect.addEventListener('change', function() {
    let degree = this.value;

    // ✅ Clear Majors + Time + degree_id
    majorSelect.innerHTML = '<option selected disabled value="">Select Major</option>';
    StudyTimeSelect.innerHTML  = '<option selected disabled value="">Select Study Time</option>';
    degreeIdInp.value    = '';

    if (!degree) return;

    fetch(`/get-majors/${degree}`)
        .then(res => res.json())
        .then(data => {
            data.forEach(item => {
                majorSelect.innerHTML +=
                    `<option value="${item.majors}">${titleCase(item.majors)}</option>`;
            });
        });
});

/* ✅ Change major */
majorSelect.addEventListener('change', function() {
    let degree = degreeSelect.value;
    let majors  = this.value;

    // ✅ Clear StudyTime + degree_id
    StudyTimeSelect.innerHTML = '<option selected disabled value="">Select Study Time</option>';
    degreeIdInp.value   = '';

    if (!majors) return;

    fetch(`/get-study_time/${degree}/${majors}`)
        .then(res => res.json())
        .then(data => {
            data.forEach(item => {
                StudyTimeSelect.innerHTML +=
                    `<option value="${item.study_time}">${titleCase(item.study_time)}</option>`;
            });
        });
});

/* ✅ Change Time */
StudyTimeSelect.addEventListener('change', function() {
    let degree = degreeSelect.value;
    let majors  = majorSelect.value;
    let study_time   = this.value;

    degreeIdInp.value = '';

    if (!study_time) return;

    fetch(`/get-degree-id/${degree}/${majors}/${study_time}`)
        .then(res => res.json())
        .then(data => {
            degreeIdInp.value = data.id; // ✅ Final FK stored here
        });
});



// async function updateDegreeId() {
//     const degree = document.getElementById('degree').value;
//     const majors = document.getElementById('majors').value;
//     const study  = document.getElementById('study_time').value;

//     if (degree && majors && study) {
//         const res = await fetch(`/get-degree-id/${degree}/${majors}/${study}`);
//         const data = await res.json();

//         if (data && data.id) {
//             document.getElementById('degree_id').value = data.id;
//         }
//     }
// }

// document.getElementById('degree').addEventListener('change', updateDegreeId);
// document.getElementById('majors').addEventListener('change', updateDegreeId);
// document.getElementById('study_time').addEventListener('change', updateDegreeId);
